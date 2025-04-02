document.addEventListener("DOMContentLoaded", function () {
    const filterForm = document.getElementById("property-filter-form");
    if (!filterForm) return;

    let shouldScrollUp = false;
    let paginationClick = false;

    // Debounce function to limit frequent calls
    function debounce(func, wait) {
        let timeout;
        return function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, arguments), wait);
        };
    }

    function showSpinner() {
        const resultsContainer = document.getElementById("property-results");
        if (resultsContainer) {
            let spinner = resultsContainer.querySelector('.spinner-overlay');
            if (!spinner) {
                spinner = document.createElement("div");
                spinner.className = "spinner-overlay";
                spinner.innerHTML = '<div class="spinner"></div>';
                resultsContainer.insertBefore(spinner, resultsContainer.firstChild);
            }
            spinner.style.display = "flex";
        }
    }

    function hideSpinner() {
        const resultsContainer = document.getElementById("property-results");
        if (resultsContainer) {
            let spinner = resultsContainer.querySelector('.spinner-overlay');
            if (spinner) spinner.style.display = "none";
        }
    }

    function updateBrowserUrl() {
        const formData = new FormData(filterForm);

        let pagedValue     = formData.get('paged') || '1';
        let condition      = formData.getAll('condition[]').join(',');
        let property_type  = formData.getAll('property_type[]').join(',');
        let location       = formData.getAll('location[]').join(',');
        let features       = formData.getAll('features[]').join(',');
        let cost_min       = formData.get('cost_min') || '';
        let cost_max       = formData.get('cost_max') || '';

        const segments = [];
        if (condition)      segments.push('condition-' + condition.replace(/\s+/g, '_'));
        if (property_type)  segments.push('property_type-' + property_type.replace(/\s+/g, '_'));
        if (location)       segments.push('location-' + location.replace(/\s+/g, '_'));
        if (features)       segments.push('features-' + features.replace(/\s+/g, '_'));
        if (cost_min)       segments.push('cost_min-' + cost_min);
        if (cost_max)       segments.push('cost_max-' + cost_max);

        let prefix = '';
        const defaultLang = 'en'; 
        const currentLang = window.siteVars?.currentLang || '';
        if (currentLang !== defaultLang && currentLang !== '') {
            prefix = '/' + currentLang;
        }

        let finalUrl = prefix + '/properties';
        if (segments.length > 0) {
            finalUrl += '/' + segments.join('/');
        }
        if (pagedValue && pagedValue !== '1') {
            finalUrl += '/page/' + pagedValue;
        }

        history.pushState(null, '', finalUrl);
    }

    function bindPaginationLinks() {
        document.querySelectorAll("#pagination-wrapper .page-numbers").forEach(link => {
            if (!link.hasAttribute('href')) return;
            link.addEventListener("click", function (e) {
                e.preventDefault();
                shouldScrollUp = true;
                paginationClick = true;
                const url = new URL(link.href, window.location.origin);
                const segments = url.pathname.split("/");
                const pageIndex = segments.indexOf("page");
                let pagedValue = pageIndex !== -1 && segments[pageIndex + 1]
                    ? parseInt(segments[pageIndex + 1], 10) || 1
                    : 1;

                let pagedInput = filterForm.querySelector('input[name="paged"]');
                if (!pagedInput) {
                    pagedInput = document.createElement("input");
                    pagedInput.type = "hidden";
                    pagedInput.name = "paged";
                    filterForm.appendChild(pagedInput);
                }
                pagedInput.value = pagedValue;
                restFilter();
            });
        });
    }

    function initCostSlider() {
        const costSlider = document.getElementById('cost-slider');
        if (!costSlider) return;

        function safeNumber(value, fallback = 0) {
            const num = parseFloat(value);
            return isNaN(num) ? fallback : num;
        }

        const costMinInput = document.getElementById('cost_min');
        const costMaxInput = document.getElementById('cost_max');
        const dynamicMin = safeNumber(costSlider.dataset.min, 0);
        const dynamicMax = safeNumber(costSlider.dataset.max, 999999999);

        if (dynamicMin >= dynamicMax) {
            console.error('Invalid slider range: min is not less than max.');
        }

        const initialMin = parseFloat(costMinInput.value) || dynamicMin;
        const initialMax = parseFloat(costMaxInput.value) || dynamicMax;

        if (!costSlider.noUiSlider) {
            const rangeTotal = dynamicMax - dynamicMin;
            const factor = rangeTotal / 10000000; 
            noUiSlider.create(costSlider, {
                start: [initialMin, initialMax],
                connect: true,
                range: {
                    'min': dynamicMin,
                    '10%': [dynamicMin + rangeTotal * 0.1, Math.max(1, Math.round(100 * factor))],
                    '40%': [dynamicMin + rangeTotal * 0.4, Math.max(1, Math.round(1000 * factor))],
                    '70%': [dynamicMin + rangeTotal * 0.7, Math.max(1, Math.round(10000 * factor))],
                    '85%': [dynamicMin + rangeTotal * 0.85, Math.max(1, Math.round(100000 * factor))],
                    'max': dynamicMax
                },
                tooltips: [true, true],
                format: {
                    to: value => Math.round(value),
                    from: value => Number(value)
                }
            });
        } else {
            costSlider.noUiSlider.set([initialMin, initialMax]);
        }

        costSlider.noUiSlider.on('update', function (values, handle) {
            if (handle === 0) costMinInput.value = values[0];
            else costMaxInput.value = values[1];
        });

        costSlider.noUiSlider.on('change', function () {
            costMinInput.dispatchEvent(new Event('change', { bubbles: true }));
            costMaxInput.dispatchEvent(new Event('change', { bubbles: true }));
        });

        costMinInput.addEventListener("change", function () {
            const newMin = parseFloat(this.value);
            if (!isNaN(newMin)) costSlider.noUiSlider.set([newMin, null]);
        });

        costMaxInput.addEventListener("change", function () {
            const newMax = parseFloat(this.value);
            if (!isNaN(newMax)) costSlider.noUiSlider.set([null, newMax]);
        });
    }

    const debouncedRestFilter = debounce(function () {
        let pagedInput = filterForm.querySelector("input[name='paged']");
        if (pagedInput) pagedInput.value = "1";
        restFilter();
    }, 300);

    function restFilter() {
        showSpinner();
        const formData = new FormData(filterForm);
        const queryString = new URLSearchParams(formData).toString();

        const currentLang = window.siteVars?.currentLang || '';
        const restUrl = (typeof wpApiSettings !== 'undefined' && wpApiSettings.root)
            ? wpApiSettings.root + 'allora/v1/filter-properties/?' + queryString + '&lang=' + currentLang
            : '/wp-json/allora/v1/filter-properties/?' + queryString + '&lang=' + currentLang;

        fetch(restUrl)
            .then(response => response.json())
            .then(data => {
                const resultsContainer = document.getElementById("property-results");
                if (!resultsContainer) {
                    hideSpinner();
                    return;
                }
                let currentPaged = parseInt(new URLSearchParams(new FormData(filterForm)).get("paged") || "1", 10);
                if (currentPaged > 1 && data.html.indexOf("No properties found") !== -1) {
                    let pagedInput = filterForm.querySelector("input[name='paged']");
                    if (!pagedInput) {
                        pagedInput = document.createElement("input");
                        pagedInput.type = "hidden";
                        pagedInput.name = "paged";
                        filterForm.appendChild(pagedInput);
                    }
                    pagedInput.value = "1";
                    restFilter();
                    return;
                }
                resultsContainer.innerHTML = data.html;

                const paginationContainer = document.getElementById("pagination-wrapper");
                if (paginationContainer) {
                    paginationContainer.innerHTML = data.pagination;
                    bindPaginationLinks();
                }
                setTimeout(() => {
                    if (typeof initGridLayout === "function") {
                        initGridLayout();
                    }
                }, 100);

                if (shouldScrollUp) {
                    resultsContainer.scrollIntoView({ behavior: "smooth" });
                    shouldScrollUp = false;
                }

                updateBrowserUrl();
                initCostSlider();
                hideSpinner();
            })
            .catch(error => hideSpinner());
    }

    filterForm.addEventListener("change", function (e) {
        if (e.target.name !== "paged") debouncedRestFilter();
        else restFilter();
        paginationClick = false;
    });

    filterForm.addEventListener("submit", function (e) {
        e.preventDefault();
        let pagedInput = filterForm.querySelector('input[name="paged"]');
        if (pagedInput) pagedInput.value = "1";
        restFilter();
    });

    initCostSlider();
    bindPaginationLinks();
});

(function() {
    const form = document.getElementById('property-filter-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // condition[]
        const condChecks = [...form.querySelectorAll('input[name=\"condition[]\"]:checked')]
            .map(ch => ch.value.trim())
            .filter(Boolean);

        // property_type[]
        const propTypeChecks = [...form.querySelectorAll('input[name=\"property_type[]\"]:checked')]
            .map(ch => ch.value.trim())
            .filter(Boolean);

        // location[]
        const locChecks = [...form.querySelectorAll('input[name=\"location[]\"]:checked')]
            .map(ch => ch.value.trim())
            .filter(Boolean);

        // features[]
        const featChecks = [...form.querySelectorAll('input[name=\"features[]\"]:checked')]
            .map(ch => ch.value.trim())
            .filter(Boolean);

        const costMin = (form.querySelector('#cost_min') || {}).value || '';
        const costMax = (form.querySelector('#cost_max') || {}).value || '';

        const segments = [];
        if (condChecks.length) {
            segments.push('condition-' + condChecks.join(','));
        }
        if (propTypeChecks.length) {
            segments.push('property_type-' + propTypeChecks.join(','));
        }
        if (locChecks.length) {
            segments.push('location-' + locChecks.join(','));
        }
        if (featChecks.length) {
            segments.push('features-' + featChecks.join(','));
        }
        if (costMin) {
            segments.push('cost_min-' + costMin);
        }
        if (costMax) {
            segments.push('cost_max-' + costMax);
        }


        let langPrefix = '';
        const defaultLang = 'en';
        if (window.siteVars && window.siteVars.currentLang) {
            const currentLang = window.siteVars.currentLang;
            if (currentLang !== defaultLang) {
                langPrefix = '/' + currentLang;
            }
        }
        let finalUrl = langPrefix + '/properties';
        if (segments.length > 0) {
            finalUrl += '/' + segments.join('/');
        }
        console.log('siteVars:', window.siteVars);
        finalUrl += '/';
        window.location.href = finalUrl;
    });
})();
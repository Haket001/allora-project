document.addEventListener("DOMContentLoaded", function () {
    const filterForm = document.getElementById("property-filter-form");
    if (!filterForm) return;

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

    filterForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(filterForm);
        let condition = formData.getAll('condition[]').join(',');
        let property_type = formData.getAll('property_type[]').join(',');
        let location = formData.getAll('location[]').join(',');
        let features = formData.getAll('features[]').join(',');
        let cost_min = formData.get('cost_min') || '';
        let cost_max = formData.get('cost_max') || '';

        const segments = [];
        if (condition) segments.push('condition-' + condition.replace(/\s+/g, '_'));
        if (property_type) segments.push('property_type-' + property_type.replace(/\s+/g, '_'));
        if (location) segments.push('location-' + location.replace(/\s+/g, '_'));
        if (features) segments.push('features-' + features.replace(/\s+/g, '_'));
        if (cost_min) segments.push('cost_min-' + cost_min);
        if (cost_max) segments.push('cost_max-' + cost_max);

        let langPrefix = '';
        const defaultLang = 'en';
        const currentLang = window.siteVars?.currentLang || '';
        if (currentLang !== defaultLang && currentLang !== '') {
            langPrefix = '/' + currentLang;
        }
        let finalUrl = langPrefix + '/properties';
        if (segments.length > 0) {
            finalUrl += '/' + segments.join('/');
        }
        finalUrl += '/';
        window.location.href = finalUrl;
    });

    window.addEventListener('load', function() {
        setTimeout(initCostSlider, 500);
    });
});
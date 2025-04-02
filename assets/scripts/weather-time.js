const city = 'Puglia';
const country = 'IT';
const wpLocale = typeof weatherTimeSettings !== 'undefined' ? weatherTimeSettings.locale.replace('_', '-') : 'it-IT';

let latestTemp = '00';

function fetchTemperature() {
    fetch('/wp-json/custom/v1/weather-data?city=' + city + '&country=' + country, {
        credentials: 'include',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.temp === undefined) {
                latestTemp = '00';
                updateDisplay();
                return;
            }
            latestTemp = data.temp;
            updateDisplay();
        })
        .catch(() => {
            latestTemp = '00';
            updateDisplay();
        });
}

function updateDisplay() {
    const now = new Date();
    const time = now.toLocaleTimeString(wpLocale, { hour: '2-digit', minute: '2-digit', hour12: false });
    const day = now.toLocaleDateString(wpLocale, { weekday: 'short' });
    document.getElementById('weather-time').innerText = `${latestTemp}°C  ${day}  ${time}`;
}

fetchTemperature();
setInterval(fetchTemperature, 600000);

updateDisplay();
setInterval(updateDisplay, 60000);
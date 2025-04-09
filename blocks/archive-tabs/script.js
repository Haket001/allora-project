// JS for ArchiveTabs block
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tab-nav li');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(el => el.classList.remove('active'));
            contents.forEach(el => el.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(tab.dataset.tab).classList.add('active');
        });
    });
});
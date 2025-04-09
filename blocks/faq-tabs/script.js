document.addEventListener('DOMContentLoaded', function(){
    const tabs = document.querySelectorAll('input[name="accordion-tabs"]');
    const contents = document.querySelectorAll('.accordion-wrap');
    
    const activeTab = document.querySelector('input[name="accordion-tabs"]:checked');
    if(activeTab) {
        const activeContent = document.querySelector('.accordion-wrap[data-tab="' + activeTab.id + '"]');
        if(activeContent) {
            activeContent.style.display = 'flex';
        }
        const activeLabel = document.querySelector('label[for="' + activeTab.id + '"]');
        if(activeLabel) {
            activeLabel.classList.add('active');
        }
    }
    
    tabs.forEach(tab => {
        tab.addEventListener('change', function(){
            const allLabels = document.querySelectorAll('label[for^="tab-"]');
            allLabels.forEach(label => label.classList.remove('active'));
            
            contents.forEach(content => content.style.display = 'none');
            
            const currentContent = document.querySelector('.accordion-wrap[data-tab="' + this.id + '"]');
            if(currentContent) {
                currentContent.style.display = 'flex';
            }
            
            const currentLabel = document.querySelector('label[for="' + this.id + '"]');
            if(currentLabel) {
                currentLabel.classList.add('active');
            }
        });
    });
});
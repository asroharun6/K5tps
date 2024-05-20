document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.menu-item');
    const sections = document.querySelectorAll('.section');
    
    const activeTabId = localStorage.getItem('activeTab');
    if (activeTabId) {
        activeTab(activeTabId);
    }

    function setActiveTab(tabId) {
        localStorage.setItem('activeTab', tabId);
    }

    menuItems.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            
            menuItems.forEach(menu => menu.classList.remove('active'));
            
            this.classList.add('active');
            
            sections.forEach(section => section.style.display = 'none');
            
            const targetSection = document.querySelector(this.getAttribute('href'));
            targetSection.style.display = 'block';

            setActiveTab(targetSection.id);
        });
    });

    function activeTab(tabId){
        menuItems.forEach(menu => menu.classList.remove('active'));
        sections.forEach(section => section.style.display = 'none');

        const activeMenuItem = document.querySelector(`.menu-item[href="#${tabId}"]`);
        if (activeMenuItem) {
            activeMenuItem.classList.add('active');
        }
        
        const activeSection = document.getElementById(tabId);
        if (activeSection) {
            activeSection.style.display = 'block';
        }
    }
});

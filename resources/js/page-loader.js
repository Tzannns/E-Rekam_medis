// Page Loading Progress Bar and Transitions
document.addEventListener('DOMContentLoaded', function() {
    // Create loading bar element
    const loadingBar = document.createElement('div');
    loadingBar.id = 'loading-bar';
    loadingBar.style.width = '0%';
    document.body.appendChild(loadingBar);

    let loadingProgress = 0;
    let loadingInterval = null;
    let isLoading = false;

    // Function to start loading
    function startLoading() {
        if (isLoading) return;
        
        isLoading = true;
        loadingProgress = 0;
        loadingBar.style.width = '0%';
        loadingBar.style.opacity = '1';
        
        // Simulate progress with smoother increments
        loadingInterval = setInterval(() => {
            if (loadingProgress < 90) {
                // Slower progress as it gets closer to 90%
                const increment = (90 - loadingProgress) * 0.1 + Math.random() * 2;
                loadingProgress += increment;
                loadingBar.style.width = Math.min(loadingProgress, 90) + '%';
            }
        }, 150);
    }

    // Function to complete loading
    function completeLoading() {
        if (!isLoading) return;
        
        clearInterval(loadingInterval);
        loadingProgress = 100;
        loadingBar.style.width = '100%';
        
        setTimeout(() => {
            loadingBar.style.opacity = '0';
            setTimeout(() => {
                loadingBar.style.width = '0%';
                isLoading = false;
            }, 300);
        }, 200);
    }

    // Intercept all navigation links
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        
        // Check if it's an internal navigation link
        if (link && 
            link.href && 
            link.href.startsWith(window.location.origin) &&
            !link.hasAttribute('target') &&
            !link.hasAttribute('download') &&
            !link.classList.contains('no-transition')) {
            
            // Don't intercept if it's the same page
            if (link.href === window.location.href) {
                e.preventDefault();
                return;
            }

            startLoading();
            
            // Add fade out effect to main content
            const mainContent = document.querySelector('main');
            if (mainContent) {
                mainContent.style.opacity = '0.6';
                mainContent.style.transition = 'opacity 0.2s ease';
            }
        }
    }, true);

    // Handle form submissions
    document.addEventListener('submit', function(e) {
        const form = e.target;
        
        // Don't show loading for delete forms (they use SweetAlert)
        if (!form.classList.contains('delete-form') && 
            !form.classList.contains('no-transition')) {
            startLoading();
        }
    }, true);

    // Complete loading when page loads
    window.addEventListener('load', completeLoading);
    
    // Also handle page show event (for back/forward navigation)
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            completeLoading();
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        startLoading();
    });

    // Add fade-in animation to main content on page load
    const mainContent = document.querySelector('main');
    if (mainContent) {
        mainContent.classList.add('content-fade');
    }
});

// Optional: Add support for Turbo/Livewire if you use them
if (typeof Livewire !== 'undefined') {
    document.addEventListener('livewire:navigating', function() {
        const loadingBar = document.getElementById('loading-bar');
        if (loadingBar) {
            loadingBar.style.width = '50%';
            loadingBar.style.opacity = '1';
        }
    });

    document.addEventListener('livewire:navigated', function() {
        const loadingBar = document.getElementById('loading-bar');
        if (loadingBar) {
            loadingBar.style.width = '100%';
            setTimeout(() => {
                loadingBar.style.opacity = '0';
            }, 200);
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    function updateThumbnailsHeight() {
        const mainImage = document.querySelector(".main-image img");
        const thumbnails = document.querySelector(".thumbnails");
        const wrapper = document.querySelector(".gallery-wrap");
        const gallery = document.querySelector(".property-gallery");

        if (mainImage && thumbnails && wrapper) {
            thumbnails.style.maxHeight = mainImage.clientHeight + "px";
            wrapper.style.maxHeight = mainImage.clientHeight + "px";
            gallery.style.maxHeight = mainImage.clientHeight + "px";
        }
    }
    updateThumbnailsHeight();
    
    // Update main image on thumbnail click
    const mainImageLink = document.getElementById("main-image-link");
    const mainImage = document.getElementById("main-image");
    const thumbnailImages = document.querySelectorAll(".thumbnails .img-wrap a img");

    thumbnailImages.forEach((thumb) => {
        thumb.addEventListener("click", function (event) {
            event.preventDefault();
            const parentAnchor = thumb.closest("a");
            const newSrc = parentAnchor.getAttribute("href");
            if (newSrc) {
                mainImage.src = newSrc;
                mainImageLink.href = newSrc;
            }
        });
    });

    window.addEventListener("resize", updateThumbnailsHeight);
    // Initialize Fancybox
    if (typeof Fancybox !== "undefined") {
        Fancybox.bind('[data-fancybox="gallery"]', {
            closeButton: 'inside'
        });
    }
});
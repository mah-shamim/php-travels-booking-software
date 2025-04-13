(function ($) {
    "use strict"
    $(document).ready(function () {

        /*==== Copy text =====*/
        const copyInput = document.querySelector('.copy-input');
        const copyText = document.querySelector('.copy-text');
        const successMessage = document.querySelector('.text-success-message');

        copyText.onclick = function () {
            // Select the text
            copyInput.select();
            // Copy it
            document.execCommand('copy');
            // Remove focus from the input
            copyInput.blur();
            // Show message
            successMessage.classList.add('active');
            // Hide message after 2 seconds
            setTimeout(function () {
                successMessage.classList.remove('active');
            }, 2000);
        };

    });

})(jQuery);
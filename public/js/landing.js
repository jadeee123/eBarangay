
document.addEventListener("DOMContentLoaded", function () {

    // Smooth scrolling for section links
    const navigationLinks = document.querySelectorAll('a[href^="#"]');

    navigationLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            const targetId = this.getAttribute("href");

            if (!targetId || targetId === "#") {
                return;
            }

            const target = document.querySelector(targetId);

            if (target) {
                event.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth"
                });
            }
        });
    });

    // Sign In modal
    const signInButtons = document.querySelectorAll(".signin-btn");
    const signInModal = document.getElementById("signinModal");

    signInButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            if (signInModal) {
                signInModal.style.display = "flex";
            }
        });
    });

    // Sign Up modal
    const signUpButtons = document.querySelectorAll(".signup-btn");
    const signUpModal = document.getElementById("signupModal");

    signUpButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            if (signUpModal) {
                signUpModal.style.display = "flex";
            }
        });
    });

    // Close modals and reset their forms
    const closeButtons = document.querySelectorAll(".close-btn");

    closeButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const modal = button.closest(".modal");

            if (!modal) return;

            modal.style.display = "none";

            const form = modal.querySelector("form");

            if (form) {
                form.reset();
            }

            // Hide passwords again
            modal.querySelectorAll(".password-input").forEach(function (input) {
                input.type = "password";
            });

            // Reset password eye icons
            modal.querySelectorAll(".password-toggle").forEach(function (toggle) {
                toggle.classList.remove("bx-hide");
                toggle.classList.add("bx-show");
            });
        });
    });

    // Close a modal by clicking its background
    document.querySelectorAll(".modal").forEach(function (modal) {
        modal.addEventListener("click", function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    });

    // Show or hide passwords
    const passwordToggles = document.querySelectorAll(".password-toggle");

    passwordToggles.forEach(function (toggle) {
        toggle.addEventListener("click", function () {
            const container = toggle.parentElement;
            const input = container.querySelector(".password-input");

            if (!input) return;

            if (input.type === "password") {
                input.type = "text";
                toggle.classList.remove("bx-show");
                toggle.classList.add("bx-hide");
            } else {
                input.type = "password";
                toggle.classList.remove("bx-hide");
                toggle.classList.add("bx-show");
            }
        });
    });

    // Switch from Sign In to Sign Up
    document.querySelectorAll(".switch-to-signup").forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            if (signInModal) signInModal.style.display = "none";
            if (signUpModal) signUpModal.style.display = "flex";
        });
    });

    // Switch from Sign Up to Sign In
    document.querySelectorAll(".switch-to-signin").forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            if (signUpModal) signUpModal.style.display = "none";
            if (signInModal) signInModal.style.display = "flex";
        });
    });

});

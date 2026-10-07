const navigationLinks = document.querySelectorAll('a[href^="#"]');

navigationLinks.forEach(function(link) {

    link.addEventListener("click", function(event) {

        const targetId = this.getAttribute("href");

        if (targetId === "#") {
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

const signInButton = document.querySelector(".signin-btn");
const signInModal = document.querySelector("#signinModal");

if (signInButton && signInModal) {

    signInButton.addEventListener("click", function(event) {

        event.preventDefault();

        signInModal.style.display = "flex";

    });

}

const signUpButton = document.querySelector(".signup-btn");
const signUpModal = document.querySelector("#signupModal");

if (signUpButton && signUpModal) {

    signUpButton.addEventListener("click", function(event) {

        event.preventDefault();

        signUpModal.style.display = "flex";

    });

}

const closeButtons = document.querySelectorAll(".close-btn");

closeButtons.forEach(function(button) {

    button.addEventListener("click", function() {

        const modal = this.closest(".modal");

        if (modal) {

            modal.style.display = "none";

            const form = modal.querySelector("form");

            if (form) {
                form.reset();
            }

            const passwordInputs = modal.querySelectorAll(".password-input");

            passwordInputs.forEach(function(input) {
                input.type = "password";
            });

            const passwordToggles = modal.querySelectorAll(".password-toggle");

            passwordToggles.forEach(function(toggle) {
                toggle.style.display = "block";
            });

        }

    });

});

const passwordToggles = document.querySelectorAll(".password-toggle");

passwordToggles.forEach(function(toggle) {

    toggle.addEventListener("click", function() {

        const input = this.parentElement.querySelector(".password-input");

        if (input.type === "password") {

            input.type = "text";

            this.classList.remove("bx-show");
            this.classList.add("bx-hide");

        } else {

            input.type = "password";

            this.classList.remove("bx-hide");
            this.classList.add("bx-show");

        }

    });

});
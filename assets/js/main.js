(function () {
    'use strict';

    // Slide elements marked with data-reveal into place as they scroll into view.
    if ('IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -8% 0px' });

        document.querySelectorAll('[data-reveal]').forEach(function (element) {
            revealObserver.observe(element);
        });
    } else {
        document.documentElement.classList.remove('reveal-ready');
    }

    // Close the mobile menu after choosing a section.
    var menu = document.getElementById('mainNav');
    menu.addEventListener('click', function (event) {
        if (event.target.closest('a') && menu.classList.contains('show')) {
            bootstrap.Collapse.getOrCreateInstance(menu).hide();
        }
    });

    // Send the enquiry form without leaving the page. If this script does not
    // run, the form still posts normally and the server redirects back.
    var form = document.getElementById('enquiryForm');
    var status = document.getElementById('formStatus');
    var submitButton = form.querySelector('[type="submit"]');
    var submitLabel = submitButton.querySelector('.btn-send-label');
    var submitText = submitLabel.textContent;

    function showStatus(ok, message) {
        var alert = document.createElement('div');
        alert.className = 'alert ' + (ok ? 'alert-success' : 'alert-danger');
        alert.textContent = message;
        status.replaceChildren(alert);
        status.scrollIntoView({ block: 'center' });
    }

    function clearFieldErrors() {
        form.querySelectorAll('.is-invalid').forEach(function (field) {
            field.classList.remove('is-invalid');
        });
    }

    function showFieldErrors(errors) {
        Object.keys(errors).forEach(function (name) {
            var field = form.elements[name];
            var feedback = form.querySelector('[data-error-for="' + name + '"]');
            if (field && feedback) {
                field.classList.add('is-invalid');
                feedback.textContent = errors[name];
            }
        });
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        clearFieldErrors();
        status.replaceChildren();
        submitButton.disabled = true;
        submitButton.classList.add('is-sending');
        submitLabel.textContent = 'Sending…';

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { Accept: 'application/json' }
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (result) {
                showStatus(result.ok, result.message);
                if (result.ok) {
                    form.reset();
                } else {
                    showFieldErrors(result.errors);
                }
            })
            .catch(function () {
                showStatus(false, 'Sorry, we could not send your enquiry. Please check your connection and try again, or call us.');
            })
            .finally(function () {
                submitButton.disabled = false;
                submitButton.classList.remove('is-sending');
                submitLabel.textContent = submitText;
            });
    });
})();

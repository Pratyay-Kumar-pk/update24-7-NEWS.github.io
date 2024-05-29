
// Show/Hide Password
$('#togglePassword').on('click', function () {
    const passwordField = $('.password');
    const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
    passwordField.attr('type', type);
    $(this).toggleClass('uil-eye uil-eye-slash');
});

// Show/Hide Confirm Password (if applicable)
$('#toggleConfirmPassword').on('click', function () {
    const passwordField = $('.confirm-password');
    const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
    passwordField.attr('type', type);
    $(this).toggleClass('uil-eye uil-eye-slash');
});

// Password Strength Checker
$('.password').on('input', function () {
    const password = $(this).val();
    const strength = getPasswordStrength(password);
    updateStrengthIndicator(strength);
});

function getPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return strength;
}

function updateStrengthIndicator(strength) {
    const bars = $('.strength-bar');
    bars.removeClass('weak medium strong very-strong');

    if (strength === 1) {
        bars.eq(0).addClass('weak');
    } else if (strength === 2) {
        bars.eq(0).addClass('medium');
        bars.eq(1).addClass('medium');
    } else if (strength === 3) {
        bars.eq(0).addClass('strong');
        bars.eq(1).addClass('strong');
        bars.eq(2).addClass('strong');
    } else if (strength === 4) {
        bars.addClass('very-strong');
    }
}


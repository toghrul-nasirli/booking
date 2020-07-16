export function isLoggedIn() {
    return localStorage.getItem('isLoggedIn') == 'true';
}

export function logIn() {
    return localStorage.setItem('isLoggedIn', true);
}

export function logOut() {
    return localStorage.setItem('isLoggedIn', false);
}

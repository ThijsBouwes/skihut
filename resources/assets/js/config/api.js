export const ENDPOINTS = {
    BASE: process.env.MIX_API_URL,
    LOGIN: 'oauth/token',
    LOGIN_REFRESH: 'oauth/token',
    PASSWORD_RESET: 'password/reset',
    FORGOT_PASSWORD: 'password/email',
    EVENTS: 'events',
    EVENTS_PAYED: 'events/payed',
    PRODUCTS: 'products',
    STOCKS: 'stocks',
    DASHBOARD: 'dashboard',
    USERS: 'users',
    USER: 'user'
};

export const HTTP_CODES = {
    UNAUTHORIZED: 401
};
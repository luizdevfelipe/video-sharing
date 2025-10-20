import api from "./api";
import { setAuthToken } from "./api";

export function parseJwtPayload(token) {
    const encodedPayload = token.split('.')[1];
    return JSON.parse(atob(encodedPayload));
}

export function autoRefreshToken(token) {
    const payload = parseJwtPayload(token);
    const exp = payload.exp;
    const currentTime = Math.floor(Date.now() / 1000);
    const timeUntilExpiry = exp - currentTime;

    if (timeUntilExpiry > 60) { 
        setTimeout(() => {
            refreshToken();
        }, (timeUntilExpiry - 60) * 1000);
    } else {
        refreshToken();
    }
}

export async function getRefreshToken() {
    try {
        const response = await api.post('/api/refresh-token');
        if (response.data.token) {
            return response.data.token;
        }
    } catch (error) {
        console.error('Failed to refresh token', error);
    }
}

export async function refreshToken() {
    const newToken = await getRefreshToken();
    if (newToken) {
        localStorage.setItem('token', newToken);
        setAuthToken(newToken);
        autoRefreshToken(newToken);
        return newToken;
    }
    return null;    
}
import axios from 'axios'
import { refreshToken } from './jwt'

const api = axios.create({
  baseURL: 'http://127.0.0.1:80',
  withCredentials: true,
  withXSRFToken: true
})

export function setAuthToken(token) {
  api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export function removeAuthToken() {
  delete api.defaults.headers.common['Authorization'];
}

api.interceptors.response.use(
  response => response,
  async error => {
    const originalRequest = error.config;

    if (error.response?.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;

      try {
        const newToken = await refreshToken();
        if (newToken) {
          originalRequest.headers['Authorization'] = `Bearer ${newToken}`;
          return api(originalRequest);
        }
      } catch (e) {
        localStorage.removeItem('token');
        removeAuthToken();
        window.location.href = '/login';
      }
    }

    return Promise.reject(error);
  }
);

export default api;

import axios from 'axios'
import { refreshToken } from './jwt'

const api = axios.create({
  baseURL: 'http://127.0.0.1:80',
  withCredentials: true,
  withXSRFToken: true
})

api.interceptors.response.use(
  response => response,
  async error => {
    const originalRequest = error.config;
    const status = error.response?.status;

    if (status !== 401 || originalRequest._retry) {
      return Promise.reject(error);
    }

    const storedToken = localStorage.getItem('token');
    if (!storedToken) {
      removeAuthToken();
      return Promise.reject(error);
    }

    if (originalRequest.url.includes('/refresh-token')) {
      removeAuthToken();
      localStorage.removeItem('token');
      window.location.href = '/login';
      return Promise.reject(error);
    }

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

    return Promise.reject(error);
  }
);

export default api;

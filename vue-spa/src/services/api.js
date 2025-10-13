import axios from 'axios'

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

export default api

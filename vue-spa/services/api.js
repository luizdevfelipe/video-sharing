import axios from 'axios'

const api = axios.create({
  baseURL: 'http://127.0.0.1:80',
  withCredentials: true,
  withXSRFToken: true
})

export default api

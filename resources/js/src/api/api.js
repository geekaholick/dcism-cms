import axios from 'axios'

const BaseApi = axios.create({
  baseURL: 'http://localhost:8000/api',
})

const Api = () => {
  const token = localStorage.getItem('token')
  if (token) {
    BaseApi.defaults.headers.common.Authorization = `Bearer ${token}`
    BaseApi.defaults.headers.common.Accept = 'application/json'
  }

  return BaseApi
}

export default Api

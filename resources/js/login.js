import axios from 'axios';

const api = axios.create({
  baseURL: '/api',
  withCredentials: true,
});

export function login(data) {
  return api.post('/login', data)
    .then(response => {
      console.log(response.data);
      return response.data;
    })
    .catch(error => {
      console.error(error);
      throw error;
    });
}

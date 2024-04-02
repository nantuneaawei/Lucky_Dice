import axios from 'axios';

export function placeBet(type, value, amount) {
  return axios.post('/api/placeBet', { type, value, amount })
    .then(response => {
      console.log(response.data);
      return response.data;
    })
    .catch(error => {
      console.error(error);
      throw error;
    });
}

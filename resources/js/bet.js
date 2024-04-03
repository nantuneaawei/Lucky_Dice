import axios from 'axios';

export function sendBetsData(betsData) {
  return axios.post('/api/placeBet', betsData)
    .then(response => {
      console.log(response.data);
      return response.data;
    })
    .catch(error => {
      console.error(error);
      throw error;
    });
}

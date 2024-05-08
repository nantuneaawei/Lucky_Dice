import axios from 'axios';

export function sendBetsData(betsData) {
  return axios.post('/api/placeBet', betsData)
    .then(response => {
      if (response.data.status) {
        alert(response.data.message);
      } else {
        alert(response.data.message);
      }
      console.log(response.data);
      return response.data;
    })
    .catch(error => {
      console.error(error);
      throw error;
    });
}

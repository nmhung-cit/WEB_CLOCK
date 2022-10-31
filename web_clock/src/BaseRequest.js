
const axios = require('axios');
const Apiurl = 'http://127.0.0.1:8000/api';

export default {
    GetHeader(){
        let token = window.localStorage.getItem('user');
        return {Authorization:'Bearer ' + token }
    },
    get(url) {
        return axios.get(
            Apiurl+url,
            {headers: this.GetHeader()})
    },
    post(url, data){
        return axios.post(
            Apiurl+url,data,
            {headers: this.GetHeader()}) 
    },
    login(url,data){
        return axios.post(
            Apiurl+url,data,
        ) 
    },
    GetUser(url) {
        return axios.get(
            Apiurl+url,)
    },
    //admin
    AdminGetHeader(){
        let token = window.localStorage.getItem('admin');
        return {Authorization:'Bearer ' + token }
    },
    GetAdmin(url) {
        return axios.get(
            Apiurl+url,
            {headers: this.AdminGetHeader()})
    },
    PostAdmin(url, data){
        return axios.post(
            Apiurl+url,data,
            {headers: this.AdminGetHeader()}) 
    },
}
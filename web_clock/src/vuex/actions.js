import BaseRequest from '@/BaseRequest/'
export default
{
    CheckUser({commit}){
        BaseRequest.get('/user-information')
        .then((response)=>{
            commit('setdata',response.data)
            BaseRequest.post('/getcart',response.data)
            .then((response)=>{
                commit('setquantity',response.data.length)
            })   
        })
        .catch(()=>{
            commit('setdata',true)
            commit('setquantity','0')
        })
    },
}
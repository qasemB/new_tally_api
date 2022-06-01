
// // upload file-------------->
// document.getElementById('submit').addEventListener('click', ()=>{
//     const data = new FormData();
//     data.append('mobile', document.getElementById('mobile').value);
//     data.append('password', document.getElementById('pass').value);
//     data.append('image', document.getElementById('image').files[0]);
//     axios.post('http://localhost:3300/api/auth/login',
//     data
//     // {mobile: '11111111111', password:'aaaaaaaa'}
//     )
//     .then(response => {
//         console.log(response.data);
//     })
//     .catch(error => console.error(error));
// })


// // login -------------->
// const data = new FormData();
// data.append('mobile', '11aa1');
// data.append('password', 'aaa');
axios.post('http://localhost:3300/api/auth/login',
// data
{mobile: '11111111111', password:'aaaaaaaa'}
)
.then(response => {
    console.log(response.data);
})
.catch(error => console.error(error));


// // get user------------->
// axios.get('http://localhost:3300/api/auth/user',{
//     headers:{
//         'Authorization' : "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpYXQiOjE2NTQwNTY5MjEsImV4cCI6MTY1NDA2MDUyMX0.__nytKvUPWdYmv-3vFLLYMX4xiiOjzAZN93tRyNQV5xt_tMaF604HKvLNYMW9F_jAVq-c4TV2ioz2uAM1z1WYVg"
//     }
// })
// .then(response => {
//     console.log(response.data);
// })
// .catch(error => console.error(error));


// // register -------------->
// axios
//   .post(
//     "http://localhost:3300/api/auth/register",
//     // data
//     {
//       user_name: "aaaaa",
//       mobile: "11111111111",
//       password: "aaaaaaaa",
//       confirm_password: "aaaaaaaa",
//       first_name: "",
//       last_name: "",
//       email: "",
//       gender: "",
//     }
//   )
//   .then((response) => {
//     console.log(response.data);
//   })
//   .catch((error) => console.error(error));


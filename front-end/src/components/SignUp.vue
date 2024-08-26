<template>
    <div class="registration-form">
      <h1 style="font-size: 64px">Регистрация</h1>

        <div class="form-group">
          <label for="username" style="margin-top: -20px">Имя пользователя</label>
          <input type="text" id="username" v-model="username" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" required>
        </div>

        <div class="form-group">
          <label for="login">Логин</label>
          <input type="text" id="login" v-model="login" required>
        </div>

        <div class="form-group">
          <label for="password">Пароль</label>
          <input type="password" id="password" v-model="password" required>
        </div>
        
        <button @click.prevent="register" class="my-button" style="margin-top: 50px">Создать<br>учетную запись</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';

  export default {
    name: "SignUp",
    data() {
      return {
        username: '',
        email: '',
        login: '',
        password: ''
      };
    },
    methods: {
        register() {
        console.log("IM REGISTERRR!!!!!!!!")

        axios.post('http://api.music.local/api/auth/signup',
        {
            login: this.login,
            password: this.password,
            email: this.email,
            username: this.username,
        }).then (token => {
          localStorage.setItem('token', token.data.access_token);
          this.$router.push('/home');
        }).catch(error => {
          console.error('Error while signing up:', error);
        });
      }
    }
  };
  </script>
  
  <style>
  .registration-form {
    max-width: 400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .form-group {
    padding-bottom: 10px;
  }
  .form-group label {
    margin-bottom: 10px;
    font-size: 32px;
  }

  .form-group input {
    width: 300px;
    background-color: #292E2D;
    border-radius: 10px;
    color: white
  }

  label {
    display: block;
  }
  input {
    width: 100%;
    padding: 0.5rem;
    font-size: 1rem;
  }


  body {
    background-color: #101211;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100vh;

    font-family: "SF Pro Text";
    color: white;
  }

  .my-button {
    border: 5px solid #fef5f5;
    border-radius: 60px;
    width: 500px;
    height: 150px;

    background-color: #101211;
    color: #fff;
    font-family: "SF Pro Text";
    font-size: 50px;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s; /* Добавляем затухание для цвета фона, текста и границы */
  }

  .my-button:hover {
    background-color: #00D6AB;
    color: black;
    border: 5px solid #00D6AB;
  }
  </style>
  
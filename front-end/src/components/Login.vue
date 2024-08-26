<template>
  <div class="registration-form">
    <h1 style="font-size: 64px">Авторизация</h1>

    <div class="form-group">
      <label for="login">Логин</label>
      <input type="text" id="login" v-model="login" required>
    </div>

    <div class="form-group">
      <label for="password">Пароль</label>
      <input type="password" id="password" v-model="password" required>
    </div>

    <button @click.prevent="loginnnn" class="my-button" style="margin-top: 50px">Вход</button>
  </div>
</template>
  
  <script>
import axios from 'axios';

  export default {
    name: "loginnnn",
    data() {
      return {
        login: '',
        password: ''
      };
    },
    methods: {
        loginnnn() {
        console.log("IM LOGINNING IN AAAAAAA!!!!!!!!")

        axios.post('http://api.music.local/api/auth/login',
        {
            login: this.login,
            password: this.password
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
  }
  .form-group {
    margin-bottom: 1rem;
  }
  label {
    display: block;
  }
  input {
    width: 100%;
    padding: 0.5rem;
    font-size: 1rem;

    border: none;
    font-family: "SF Pro Text";
  }
  button {
    padding: 0.5rem 1rem;
    font-size: 1rem;
    font-weight: bold;
  }
  </style>
  
<template>
  <body>
    <h1 class="title">Saiterfy</h1>

    <h3 class="sub-title">Лучший бесплатный музыкальный сервис</h3>
    <div style="display: flex; flex-direction: row; margin-top: 200px">
      <router-link to="signup" style="margin-right: 70px">
        <button class = "my-button">Регистрация</button>
      </router-link>

      <router-link to="login" style="margin-left: 70px">
        <button class = "my-button">Авторизация</button>
      </router-link>
    </div>
  </body>

</template>

<script>
export default {
  name: "IndexPage"
}
</script>

<style scoped>

* {
  margin: -8px;
  padding: 0;
}

.title {
  display: flex;
  font-family: "SF Pro Text";
  font-size: 160px;
  color: #fff;

  margin-top: 200px;
}

.sub-title {
  display: flex;
  font-family: "SF Pro Text";
  font-size: 60px;
  color: #fff;
  margin-top: 10px;
}

body {
  background-color: #101211;
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100vh;
}

.my-button {
  border: 5px solid #fef5f5;
  border-radius: 60px;
  width: 400px;
  height: 120px;

  background-color: #101211;
  color: #fff;
  font-family: "SF Pro Text";
  font-size: 50px;
  font-weight: bold;
  transition: background-color 0.3s, color 0.3s, border-color 0.3s; /* Добавляем затухание для цвета фона, текста и границы */
}

.my-button:hover {
  background-color: #00D6AB;
  color: black;
  border: 5px solid #00D6AB;
}

</style>
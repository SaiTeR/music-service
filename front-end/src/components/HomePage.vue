<template>
  <body>
  <div class="navbar">
    <button @click.prevent="" class="nav-bar-button" style="margin-top: 50px">Главная</button>
    <button @click.prevent="getAllUsers" class="nav-bar-button" style="margin-top: 50px">Пользователи</button>
    <button @click.prevent="getAllArtists" class="nav-bar-button" style="margin-top: 50px">Артисты</button>
    <button @click.prevent="getAllAlbums" class="nav-bar-button" style="margin-top: 50px">Альбомы</button>
    <button @click.prevent="getAllPlaylists" class="nav-bar-button" style="margin-top: 50px">Плейлисты</button>
    <button @click.prevent="myFavorites" class="nav-bar-button" style="margin-top: 50px; color: #00D6AB">Любимые</button>
    <div v-if="imageUrl" class="profile-block">
      <img :src="imageUrl" alt="Изображение">
      <button @click.prevent="" class="nav-bar-button" style="margin-top: 50px">{{ username }}</button>
    </div>
  </div>

  <div class="content" v-if="content.length > 0">
    <div class="main-block" v-if="contentType === 'home'">
      <div>
        <h1>Создать артиста</h1>
        <div class="form-group">
          <label>Имя артиста</label>
          <input type="text" id="artsitName" v-model="artistName" required>
        </div>
        <div class="form-group">
          <label>Изображение</label>
          <input type="file" id="artistImage" ref="fileInput">
        </div>
        <button @click.prevent="createArtist">Создать артиста</button>
      </div>


    </div>

    <div v-for="user in content" class="content-entity" v-if="contentType === 'users'">
      <img :src="user.imageUrl" style="border-radius: 100%" alt="Аватар пользователя">
      <p class="content-title-text" style="text-align: center; font-size: 28px; margin-top: 15px">{{ user.username }}</p>
    </div>

    <div v-for="artist in content" class="content-entity" v-if="contentType === 'artists'">
      <img :src="artist.imageUrl">
      <p class="content-title-text">{{ artist.artistName }}</p>
      <p class="content-other-text">{{ artist.ownerName }}</p>
      <p class="content-other-text">Слушатели: {{ artist.monthlyListeners }}</p>
    </div>

    <div v-for="album in content" class="content-entity" v-if="contentType === 'albums'">
      <img :src="album.imagePath" alt="Аватар пользователя">
      <div style="display: flex; flex-direction: row">
        <p class="content-title-text">{{ album.albumName }}</p>
        <p v-if="album.isExplicit" class="content-other-text explicit">E</p>
      </div>
      <p class="content-other-text">{{ album.artistName }}</p>
      <div style="display: flex; flex-direction: row">
        <p class="content-other-text">{{ album.albumType }}</p>
        <span class="separator"></span>
        <p class="content-other-text">{{ album.releaseYear }}</p>
      </div>
    </div>

    <div v-for="playlist in content" class="content-entity" v-if="contentType === 'playlists'">
      <img :src="playlist.imageUrl" alt="Аватар пользователя">
      <p class="content-title-text">{{ playlist.playlistName }}</p>
      <p class="content-other-text">{{ playlist.ownerName }}</p>
      <p class="content-other-text">Кол-во песен: {{ playlist.songsAmount}}</p>
    </div>

    <div class="content-entity" v-if="contentType === 'favorites'">
      <my-favorites></my-favorites>
    </div>
  </div>
  </body>
</template>

<script>
import axios from "axios";
import MyFavorites from '@/components/MyFavorites.vue';


export default {
  name: "MainPage",

  components: {
    MyFavorites
  },

  data() {
    return {
      username: "",
      imageUrl: "",

      content: "home",
      contentType: "home",


      artistName: "",
    };
  },

  created() {
    this.getMyUser();
  },

  methods: {
    createArtist() {
      const token = localStorage.getItem('token'); // Получаем Bearer токен из локального хранилища
      if (!token) {
        console.error('Token not found');
        return;
      }

      const config = {
        headers: {
          Authorization: `Bearer ${token}`
        }
      };

      const formData = new FormData();
      formData.append('artistName', this.artistName); // Передаем имя артиста
      formData.append('image', this.$refs.fileInput.files[0]); // Передаем файл изображения артиста

      axios.post('http://api.music.local/api/artists', formData, config)
          .then(response => {
            // Получаем данные из ответа
            console.log("Артист сохранен")

          })
          .catch(error => {
            console.error('Error while fetching content:', error);
          });

    },

    getMyUser() {
      const token = localStorage.getItem('token'); // Получаем Bearer токен из локального хранилища
      if (!token) {
        console.error('Token not found');
        return;
      }

      const config = {
        headers: {
          Authorization: `Bearer ${token}`
        }
      };

      axios.get('http://api.music.local/api/users/me', config)
          .then(response => {
            // Получаем данные из ответа
            const data = response.data;
            this.username = data.username;
            this.imageUrl = data.imageUrl;

          })
          .catch(error => {
            console.error('Error while fetching content:', error);
          });
    },



    getAllUsers() {
      console.log("geting all users!");
      const token = localStorage.getItem('token'); // Получаем Bearer токен из локального хранилища
      if (!token) {
        console.error('Token not found');
        return;
      }

      const config = {
        headers: {
          Authorization: `Bearer ${token}`
        }
      };

      this.contentType = "users"
      this.content = ""

      // Отправляем GET-запрос с Bearer токеном
      axios.get('http://api.music.local/api/users/all', config)
          .then(response => {
            // Получаем данные из ответа
            const data = response.data;

            // Выводим полученные данные в блок <p>
            this.content = data;
          })
          .catch(error => {
            console.error('Error while fetching content:', error);
          });
    },

    getAllArtists() {
      const token = localStorage.getItem('token'); // Получаем Bearer токен из локального хранилища
      if (!token) {
        console.error('Token not found');
        return;
      }

      const config = {
        headers: {
          Authorization: `Bearer ${token}`
        }
      };

      this.contentType = "artists"
      this.content = ""
      // Отправляем GET-запрос с Bearer токеном
      axios.get('http://api.music.local/api/artists/all', config)
          .then(response => {
            // Получаем данные из ответа
            const data = response.data;

            // Выводим полученные данные в блок <p>
            this.content = data;
          })
          .catch(error => {
            console.error('Error while fetching content:', error);
          });
    },

    getAllAlbums() {
      const token = localStorage.getItem('token'); // Получаем Bearer токен из локального хранилища
      if (!token) {
        console.error('Token not found');
        return;
      }

      this.contentType = "albums"
      this.content = ""

      const config = {
        headers: {
          Authorization: `Bearer ${token}`
        }
      };

      // Отправляем GET-запрос с Bearer токеном
      axios.get('http://api.music.local/api/albums/all', config)
          .then(response => {
            // Получаем данные из ответа
            const data = response.data;
            console.log(data);
            // Выводим полученные данные в блок <p>
            this.content = data;
          })
          .catch(error => {
            console.error('Error while fetching content:', error);
          });
    },

    getAllPlaylists() {
      const token = localStorage.getItem('token'); // Получаем Bearer токен из локального хранилища
      if (!token) {
        console.error('Token not found');
        return;
      }

      const config = {
        headers: {
          Authorization: `Bearer ${token}`
        }
      };

      this.contentType = "playlists"
      this.content = ""

      // Отправляем GET-запрос с Bearer токеном
      axios.get('http://api.music.local/api/playlists/all', config)
          .then(response => {
            // Получаем данные из ответа
            const data = response.data;

            // Выводим полученные данные в блок <p>
            this.content = data;
          })
          .catch(error => {
            console.error('Error while fetching content:', error);
          });
    },

    myFavorites() {
      this.contentType = "favorites"
      this.content = ""
    }
  }

}


</script>

<style scoped>

.content{
  display: flex;
  flex-wrap: wrap;
  width: 71.25%;
  margin-top: 30px;
}

.content-entity{
  width: 200px;
  height: 270px;

  padding: 10px;
  margin: 20px;

  border: 3px solid transparent; /* устанавливаем невидимую обводку */
  transition: border-color 0.3s; /* добавляем плавный переход для обводки */
}

.content-entity:hover {
  border-color: #00D6AB; /* меняем цвет обводки при наведении */
}

.content-entity img{
  width: 200px;
  height: 200px;
}

.content-title-text{
  font-size: 20px;

  margin-top: 2px;
  text-align: left;
}

.content-other-text{
  margin-top: -20px;
  font-weight: normal;
  text-align: left;
  color: gray; font-size: 18px;
}

.explicit{
  padding: 0;
  margin-top: 2px;
  margin-left: auto;

  background-color: #343938;
  color: white;


  padding: 2px;
  padding-top: 1px;
  height: 20px;
  width: 16px;
  text-align: center;

  border-radius: 5px;
}

.separator {
  display: inline-block;
  width: 2px;
  height: 2px;
  margin: -10px 6px 0;
  content: "";
  overflow: hidden;
  vertical-align: middle;
  background-color: gray;
  border-radius: 100%;
}

/*******************************************/

.profile-block {
  display: flex;
  flex-direction: row;

  margin-left: 250px;
}

.profile-block img {
  width: 75px;
  height: 75px;
  /*align-self: flex-end; !* Перемещение изображения вниз внутри flex-контейнера *!*/
  margin-top: 50px;
  border-radius: 50%; /* делает изображение круглым */
}
.navbar {
  display: flex;
  flex-direction: row;
  margin-top: -35px;
}
.nav-bar-button {
  position: relative; /* Добавляем позиционирование, чтобы ::after был позиционирован относительно .nav-bar-button */
  border: none; /* Убираем изначальную границу */

  padding-left: 30px;
  padding-right: 30px;

  background-color: #101211;
  color: #fff;
  font-family: "SF Pro Text";
  font-size: 30px;
  font-weight: bold;
  transition: color 0.3s; /* Удаляем transition для border-color и background-color, так как они будут управляться ::after */
}

.nav-bar-button::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -5px; /* Располагаем обводку снизу кнопки */
  width: 100%;
  height: 5px; /* Задаем высоту обводки */
  background-color: transparent;
  transition: background-color 0.3s; /* Добавляем transition для обводки */
}

.nav-bar-button:hover::after {
  background-color: #00D6AB; /* Изменяем цвет обводки при наведении на кнопку */
}

.main-block{
  display:flex;

}

</style>
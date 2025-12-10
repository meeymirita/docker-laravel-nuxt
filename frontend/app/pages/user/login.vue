<script setup lang="ts">

import {ref} from "vue";

const login = ref();
const password = ref();
const errorMessage = ref('');
const loginEvent = async () => {
  if (!login.value || !password.value) {
    errorMessage.value = 'Заполните все поля';
    return;
  }
  const prod = 'https://meeymirita.ru/';
  const local = 'http://localhost:8080/';

  console.log('Login:', login.value);
  console.log('Password:', password.value);

  const formData = new FormData();
  formData.append('login', login.value);
  formData.append('password', password.value);
  try {
    const response = await $fetch(`${local}api/user/login`, {
      method: 'POST',
      body: formData,
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();
    console.log('Успех:', result);
  } catch (error) {
    console.log(error)
    errorMessage.value = error.message
  }
}
</script>

<template>
  <div class="container">
    <form class="form">
      <h2 class="form-title">Вход</h2>

      <div class="input-group">
        <label for="login" class="input-label">Логин</label>
        <input
            type="text"
            id="login"
            v-model="login"
            class="input-field"
            placeholder="Введите логин или почту"
        >
      </div>

      <div class="input-group">
        <label for="password" class="input-label">Пароль</label>
        <input
            type="text"
            id="password"
            v-model="password"
            class="input-field"
            placeholder="Введите пароль"
        >
      </div>
      <div v-if="errorMessage">
        <label class="errorMessage" >{{errorMessage}}</label>
      </div>
      <button @click.prevent="loginEvent()" class="submit-button">
        Войти
      </button>

      <div class="form-footer">
        <NuxtLink class="link" to="/user/register" >Регистрация</NuxtLink>
        <NuxtLink class="link" to="/user/send-reset-link" >Забыли пароль?</NuxtLink>
      </div>
    </form>
  </div>
</template>

<style scoped lang="scss">
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  padding: 20px;
}

.form {
  background: white;
  border-radius: 20px;
  padding: 40px;
  width: 100%;
  max-width: 620px;
  box-shadow:
      0 15px 35px rgba(50, 50, 93, 0.1),
      0 5px 15px rgba(0, 0, 0, 0.07);
  transition: all 0.3s ease;

  &:hover {
    box-shadow:
        0 18px 40px rgba(50, 50, 93, 0.15),
        0 8px 20px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
  }
}

.form-title {
  text-align: center;
  color: #333;
  font-size: 28px;
  font-weight: 600;
  margin-bottom: 32px;
  letter-spacing: -0.5px;
}

.input-group {
  margin-bottom: 24px;
}

.input-label {
  display: block;
  color: #555;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 8px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.input-field {
  width: 100%;
  padding: 14px 16px;
  border: 2px solid #e1e5e9;
  border-radius: 10px;
  font-size: 16px;
  color: #333;
  background: #f8f9fa;
  transition: all 0.3s ease;

  &:focus {
    outline: none;
    border-color: #ff6f6f;
    background: white;
    box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
  }

  &::placeholder {
    color: #aaa;
  }
}

.submit-button {
  width: 100%;
  padding: 16px;
  background: #ff6f6f;
  color: white;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: 10px;
  box-shadow: 0 4px 15px rgba(74, 108, 247, 0.25);

  &:hover {
    background: #ff9191;
    box-shadow: 0 6px 20px rgba(74, 108, 247, 0.35);
    transform: translateY(-1px);
  }

  &:active {
    transform: translateY(1px);
    box-shadow: 0 2px 10px rgba(74, 108, 247, 0.25);
  }
}

.form-footer {
  display: flex;
  justify-content: space-between;
  margin-top: 24px;
  padding-top: 24px;
  border-top: 1px solid #eee;
}

.link {
  color: #ff6f6f;
  text-decoration: none;
  font-size: 14px;
  font-weight: 500;
  transition: color 0.3s ease;

  &:hover {
    color: #ff9191;
    text-decoration: underline;
  }
}
.errorMessage{
  display: block;
  color: #ff9191;
  font-size: 14px;
  font-weight: 500;
  margin-bottom: 8px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.form {
  animation: fadeInUp 0.6s ease-out;
}

@media (max-width: 480px) {
  .form {
    padding: 30px 24px;
    border-radius: 16px;
  }

  .form-title {
    font-size: 24px;
    margin-bottom: 28px;
  }

  .form-footer {
    flex-direction: column;
    gap: 12px;
    text-align: center;
  }
}
</style>
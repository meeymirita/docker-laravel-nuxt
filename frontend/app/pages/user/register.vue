<script setup>
import { ref } from 'vue'

const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const errorMessage = ref('')
const validationErrors = ref({})
const registerForm = ref(true)
const confirmationCodeShow = ref(false)
const loading = ref(false)

const register = async () => {
  const local = 'http://localhost:8080/'

  // Сброс ошибок
  errorMessage.value = ''
  validationErrors.value = {}
  loading.value = true



  const formData = new FormData()
  formData.append('email', email.value)
  formData.append('password', password.value)
  formData.append('password_confirmation', password_confirmation.value)

  try {
    const response = await $fetch(`${local}api/user/register`, {
      method: 'POST',
      body: formData,
    });

    // Если здесь, значит запрос успешен (статус 200-299)
    console.log('Успех:', response);

    // navigateTo('/dashboard');

  } catch (error) {
    console.log('Полная ошибка:', error);

    if (error.data) {
      const errorData = error.data;

      if (errorData.errors) {
        validationErrors.value = errorData.errors;
        const firstError = Object.values(errorData.errors)[0]?.[0];
        if (firstError) {
          errorMessage.value = firstError;
        } else {
          errorMessage.value = errorData.message || 'Ошибка валидации';
        }
      } else {
        errorMessage.value = errorData.message || 'Неизвестная ошибка';
      }
    } else {
      errorMessage.value = error.message || 'Ошибка сети или сервера';
    }
  }
}
</script>
<template>
  <div class="container">
    <form class="form">
      <h2 class="form-title">Регистрация</h2>
      <div v-if="registerForm">
        <div class="input-group">
          <label for="email" class="input-label">Электронная почта</label>
          <input
              type="text"
              id="email"
              v-model="email"
              class="input-field"
              :class="{ 'error': validationErrors.email }"
              placeholder="Введите email"
          >
          <div v-if="validationErrors.email" class="validation-error">
            {{ validationErrors.email[0] }}
          </div>
        </div>

        <div class="input-group">
          <label for="password" class="input-label">Пароль</label>
          <input
              type="password"
              id="password"
              v-model="password"
              class="input-field"
              :class="{ 'error': validationErrors.password }"
              placeholder="Введите пароль"
          >
          <div v-if="validationErrors.password" class="validation-error">
            {{ validationErrors.password[0] }}
          </div>
        </div>
        <div class="input-group">
          <label for="confirmPassword" class="input-label">Подтверждение пароля</label>
          <input
              type="password"
              id="password_confirmation"
              v-model="password_confirmation"
              class="input-field"
              :class="{ 'error': validationErrors.password_confirmation }"
              placeholder="Подтверждение пароля"
          >

        </div>
        <div v-if="errorMessage" class="error-message">
          {{ errorMessage }}
        </div>
        <button @click.prevent="register" class="submit-button">
          Зарегистрироваться
        </button>
      </div>

      <div v-if="confirmationCodeShow" style="margin-top: 30px" class="input-group">
        <label for="confirmationCode" class="input-label">Код подтверждения</label>
        <div class="confirmation-input-group">
          <input
              type="text"
              id="confirmationCode"
              name="confirmationCode"
              class="input-field confirmation-field"
              placeholder="Введите код"
          >
          <button type="button" class="send-code-button">Отправить</button>
        </div>
      </div>

      <div class="form-footer">
        <NuxtLink class="link" to="/user/login">Вход</NuxtLink>
        <NuxtLink class="link" to="/user/send-reset-link">Забыли пароль?</NuxtLink>
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
  padding: 50px;
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

.confirmation-input-group {
  display: flex;
  gap: 12px;
}

.confirmation-field {
  flex: 1;
}

.send-code-button {
  padding: 14px 24px;
  color: black;
  border: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  white-space: nowrap;
  min-width: 120px;

  &:hover {
    background: #ff6f6f;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(74, 108, 247, 0.3);
  }

  &:active {
    transform: translateY(0);
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

  .confirmation-input-group {
    flex-direction: column;
  }

  .send-code-button {
    width: 100%;
    padding: 16px;
    font-size: 16px;
  }

  .form-footer {
    flex-direction: column;
    gap: 12px;
    text-align: center;
  }
}
.error-message {
  background-color: #fee;
  color: #c33;
  padding: 12px 16px;
  border-radius: 8px;
  margin: 20px 0;
  border: 1px solid #fcc;
  font-size: 14px;
  font-weight: 500;
  text-align: center;
  animation: fadeIn 0.3s ease;
}

.validation-error {
  color: #e53e3e;
  font-size: 12px;
  margin-top: 6px;
  font-weight: 500;
  padding-left: 4px;
  animation: fadeIn 0.3s ease;
}

/* Добавьте красную рамку для полей с ошибками */
.input-field.error {
  border-color: #e53e3e;
  background-color: #fff5f5;

  &:focus {
    border-color: #c53030;
    box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
  }
}

/* Анимация для плавного появления ошибок */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-5px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
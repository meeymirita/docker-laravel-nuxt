<template>
  <div class="verify-email-page">
    <div class="container">
      <div v-if="loading" class="loading">
        <p>Проверка email...</p>
        <div class="spinner"></div>
      </div>

      <div v-else-if="success" class="success">
        <h1>✅ Email успешно подтверждён!</h1>
        <p>{{ message }}</p>
        <button @click="redirectToLogin" class="btn-primary">
          Войти в аккаунт
        </button>
      </div>

      <div v-else class="error">
        <h1>❌ Ошибка подтверждения email</h1>
        <p>{{ errorMessage }}</p>
        <div class="actions">
          <button @click="retryVerification" class="btn-secondary">
            Попробовать снова
          </button>
          <button @click="redirectToHome" class="btn-link">
            На главную
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from '#app'

const route = useRoute()
const router = useRouter()

const loading = ref(true)
const success = ref(false)
const message = ref('')
const errorMessage = ref('')

const verifyEmail = async () => {
  try {
    loading.value = true

    const { id, hash, expires, signature } = route.query

    if (!id || !hash) {
      throw new Error('Неверная ссылка для подтверждения email')
    }
    const prod = 'https://meeymirita.ru/';
    const local = 'http://localhost:8080/';
    const response = await $fetch(`${local}api/email/verify/${id}/${hash}`, {
      method: 'GET',
      params: {
        expires,
        signature
      },
      headers: {
        'Accept': 'application/json',
      }
    })
    if (response.success) {
      success.value = true
      message.value = response.message || 'Ваш email успешно подтверждён!'
    } else {
      throw new Error(response.message || 'Ошибка подтверждения email')
    }
  } catch (error) {
    console.error('Email verification error:', error)
    errorMessage.value = error.message || 'Произошла ошибка при подтверждении email'
    success.value = false
  } finally {
    loading.value = false
  }
}

const retryVerification = () => {
  loading.value = true
  verifyEmail()
}

const redirectToLogin = () => {
  router.push('/login')
}

const redirectToHome = () => {
  router.push('/')
}

onMounted(() => {
  verifyEmail()
})
</script>

<style scoped>
.verify-email-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.container {
  background: white;
  padding: 3rem;
  border-radius: 12px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  max-width: 500px;
  width: 90%;
  text-align: center;
}

.loading {
  color: #667eea;
}

.spinner {
  margin: 2rem auto;
  width: 50px;
  height: 50px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #667eea;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.success h1 {
  color: #10b981;
  margin-bottom: 1rem;
}

.error h1 {
  color: #ef4444;
  margin-bottom: 1rem;
}

.btn-primary {
  background: #667eea;
  color: white;
  border: none;
  padding: 12px 30px;
  border-radius: 6px;
  font-size: 16px;
  cursor: pointer;
  margin-top: 1rem;
  transition: background 0.3s;
}

.btn-primary:hover {
  background: #5a67d8;
}

.btn-secondary {
  background: #f3f4f6;
  color: #374151;
  border: 1px solid #d1d5db;
  padding: 10px 20px;
  border-radius: 6px;
  cursor: pointer;
  margin: 0.5rem;
  transition: all 0.3s;
}

.btn-secondary:hover {
  background: #e5e7eb;
}

.btn-link {
  background: none;
  border: none;
  color: #667eea;
  cursor: pointer;
  margin: 0.5rem;
  padding: 10px 20px;
}

.btn-link:hover {
  text-decoration: underline;
}

.actions {
  margin-top: 1.5rem;
  display: flex;
  justify-content: center;
  gap: 1rem;
}
</style>
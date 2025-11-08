<template>
  <div class="container">
    <div class="verification-card">
      <div v-if="pending" class="status loading">
        <div class="spinner"></div>
        <h2>Подтверждаем ваш email...</h2>
      </div>

      <div v-else-if="error" class="status error">
        <div class="icon">❌</div>
        <h2>Ошибка подтверждения</h2>
        <p>{{ error.data?.message || error.message }}</p>
        <button @click="verifyEmail" class="btn">Попробовать снова</button>
      </div>

      <div v-else class="status success">
        <div class="icon">✅</div>
        <h2>Email подтвержден! 🎉</h2>
        <p>Перенаправляем на страницу входа...</p>
      </div>
    </div>
  </div>
</template>

<script setup>
const route = useRoute()

// Получаем ВСЕ параметры из query строки
const { id, hash, expires, signature } = route.query

console.log('Параметры:', { id, hash, expires, signature })

// Функция верификации
const { data, pending, error, execute } = await useFetch(
    `http://localhost:8080/api/email/verify/${id}/${hash}`,
    {
      method: 'GET',
      query: { expires, signature },
      immediate: false
    }
)

// Запускаем верификацию при загрузке
onMounted(() => {
  if (id && hash) {
    verifyEmail()
  }
})

const verifyEmail = async () => {
  await execute()
}

// Редирект при успехе
watch(() => data.value, (newData) => {
  if (newData?.success) {
    setTimeout(() => {
      navigateTo('/')
    }, 3000)
  }
})
</script>

<style scoped>
.container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.verification-card {
  background: white;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  max-width: 500px;
  width: 100%;
}

.loading .spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #e3e3e3;
  border-top: 4px solid #1976d2;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto 20px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.success {
  color: green;
}

.error {
  color: red;
}

.btn {
  padding: 10px 20px;
  background-color: #1976d2;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
</style>
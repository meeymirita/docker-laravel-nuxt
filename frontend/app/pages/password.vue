<template>
  <div class="wrapper">
    <form @submit.prevent="handleReset">
      <input type="email" v-model="email" placeholder="Email" readonly>
      <input type="password" v-model="password" placeholder="Password">
      <input type="password" v-model="password_confirmation" placeholder="Password confirmation">
      <button class="loginbut" type="submit" :disabled="loading">
        {{ loading ? "Sending..." : "Reset" }}
      </button>
    </form>
  </div>
</template>

<script setup>
const route = useRoute()

const token = route.query.token
const email = ref(route.query.email || '')

const password = ref('')
const password_confirmation = ref('')

const loading = ref(false)
const success = ref(false)
const error = ref('')

async function handleReset() {
  loading.value = true
  success.value = false
  error.value = ''

  try {
    await $fetch('http://localhost:8080/api/reset-password', {
      method: 'POST',
      body: {
        email: email.value,
        token,
        password: password.value,
        password_confirmation: password_confirmation.value,
      },
    })

    success.value = true
    alert('✅ Пароль успешно изменён!')
  } catch (err) {
    error.value = err?.data?.message || 'Ошибка при сбросе пароля'
    alert('❌ ' + error.value)
  } finally {
    loading.value = false
  }
}
</script>

<style lang="scss" scoped>

</style>
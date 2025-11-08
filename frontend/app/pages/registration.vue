<template>
  <div class="wrapper">
    <h1>Registration</h1>
    <form>
      <input v-model="data.name" type="text" id="name" placeholder="Name">
      <input v-model="data.login" name="login" type="email" id="email" placeholder="Login">
      <input v-model="data.email" name="email" type="tel" id="phone" placeholder="Email">
      <input v-model="data.password" type="text" id="password" placeholder="Password">
      <input v-model="data.password_confirmation" type="text" id="password_confirmation" placeholder="Password confirmation">
    </form>
    <button class="loginbut" type="button" @click="handleReset">Register</button>
    <h2 class="tip">Already have an account? <a class="login" href="main.html" target="">Login</a></h2>
  </div>
</template>


<script setup>
const data = ref(
    {
      name: null,
      login: null,
      email: null,
      password: null,
      password_confirmation: null,
    }
)

async function handleReset() {
  try {
    await $fetch('http://localhost:8080/api/user/register', {
      method: 'POST',
      body:data.value
    })
  }catch (err){
    console.log(err.status)
    console.log(err.data)
  }
}
</script>

<style lang="scss" scoped>

</style>
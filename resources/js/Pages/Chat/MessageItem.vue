<template>
    <div>
        {{message.user.name}}: {{message.message}}
    </div>
</template>
<script setup>

   const props = defineProps({
        message: Object
   })
</script>

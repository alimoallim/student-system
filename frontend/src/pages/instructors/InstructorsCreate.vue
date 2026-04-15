<template>
  <div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-2">Create Instructor</h2>
    <p class="text-slate-600 text-sm mb-6">Add instructor profile</p>

    <form @submit.prevent="submit" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-semibold text-slate-700">Instructor ID</label>
          <input v-model="form.instructor_id" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400"/>
        </div>
        <div>
          <label class="text-sm font-semibold text-slate-700">Full Name</label>
          <input v-model="form.full_name" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400"/>
        </div>
      </div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-semibold text-slate-700">Email (optional)</label>
          <input v-model="form.email" type="email" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400"/>
        </div>
        <div>
          <label class="text-sm font-semibold text-slate-700">Department (optional)</label>
          <input v-model="form.department" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400"/>
        </div>
      </div>

      <p v-if="error" class="text-rose-700 text-sm font-semibold">{{ error }}</p>

      <div class="flex items-center justify-between gap-3 pt-2">
        <router-link to="/instructors" class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 font-semibold">
          Cancel
        </router-link>

        <button class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold" :disabled="submitting">
          {{ submitting ? "Creating..." : "Create" }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { api, handleApiError } from "../../api/client";
import { useRouter } from "vue-router";

const router = useRouter();
const submitting = ref(false);
const error = ref("");

const form = reactive({
  instructor_id: "",
  full_name: "",
  email: "",
  department: "",
});

async function submit() {
  submitting.value = true;
  error.value = "";
  try {
    await api.post("/instructors", form);
    router.push("/instructors");
  } catch (err) {
    error.value = handleApiError(err);
  } finally {
    submitting.value = false;
  }
}
</script>
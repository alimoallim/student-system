<template>
  <div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-2">Edit Student</h2>
    <p class="text-slate-600 text-sm mb-6">Update user + student profile</p>

    <form v-if="loaded" @submit.prevent="submit" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-semibold text-slate-700">Name</label>
          <input v-model="form.name" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400" />
        </div>

        <div>
          <label class="text-sm font-semibold text-slate-700">Email</label>
          <input v-model="form.email" type="email" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400" />
        </div>
      </div>

      <div>
        <label class="text-sm font-semibold text-slate-700">Student ID</label>
        <input v-model="form.student_id" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400" />
      </div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-semibold text-slate-700">Major</label>
          <input v-model="form.major" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400" />
        </div>

        <div>
          <label class="text-sm font-semibold text-slate-700">Batch</label>
          <input v-model="form.batch" class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400" />
        </div>
      </div>

      <div>
        <label class="text-sm font-semibold text-slate-700">New Password (optional)</label>
        <input v-model="form.password" type="password" placeholder="Leave blank to keep current"
          class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-400" />
      </div>

      <p v-if="error" class="text-rose-700 text-sm font-semibold">{{ error }}</p>

      <div class="flex items-center justify-between gap-3 pt-2">
        <router-link to="/students" class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 font-semibold">
          Back
        </router-link>

        <button class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold" :disabled="submitting">
          {{ submitting ? "Saving..." : "Save Changes" }}
        </button>
      </div>
    </form>

    <div v-else class="p-4 text-slate-600">Loading...</div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
import { api, handleApiError } from "../../api/client";
import { useRouter, useRoute } from "vue-router";

const route = useRoute();
const router = useRouter();

const loaded = ref(false);
const submitting = ref(false);
const error = ref("");

const form = reactive({
  name: "",
  email: "",
  student_id: "",
  major: "",
  batch: "",
  password: "",
});

onMounted(async () => {
  try {
    const res = await api.get(`/students/${route.params.id}`);
    const s = res.data;

    form.name = s.user?.name || "";
    form.email = s.user?.email || "";
    form.student_id = s.student_id || "";
    form.major = s.major || "";
    form.batch = s.batch || "";
    loaded.value = true;
  } catch (err) {
    alert(handleApiError(err));
    router.push("/students");
  }
});

async function submit() {
  submitting.value = true;
  error.value = "";

  const payload = {
    name: form.name,
    email: form.email,
    student_id: form.student_id,
    major: form.major,
    batch: form.batch,
  };

  if (form.password) payload.password = form.password;

  try {
    await api.put(`/students/${route.params.id}`, payload);
    router.push("/students");
  } catch (err) {
    error.value = handleApiError(err);
  } finally {
    submitting.value = false;
  }
}
</script>
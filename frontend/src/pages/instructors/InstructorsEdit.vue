<template>
  <div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-2">Edit Instructor</h2>

    <form v-if="loaded" @submit.prevent="submit" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
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
  instructor_id: "",
  full_name: "",
  email: "",
  department: "",
});

onMounted(async () => {
  try {
    const res = await api.get(`/instructors/${route.params.id}`);
    const i = res.data;

    form.instructor_id = i.instructor_id || "";
    form.full_name = i.full_name || "";
    form.email = i.email || "";
    form.department = i.department || "";

    loaded.value = true;
  } catch (err) {
    alert(handleApiError(err));
    router.push("/instructors");
  }
});

async function submit() {
  submitting.value = true;
  error.value = "";
  try {
    await api.put(`/instructors/${route.params.id}`, form);
    router.push("/instructors");
  } catch (err) {
    error.value = handleApiError(err);
  } finally {
    submitting.value = false;
  }
}
</script>
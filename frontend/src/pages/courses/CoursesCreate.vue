<template>
  <div class="max-w-4xl mx-auto">
    
    <!-- Header -->
    <div class="mb-6">
      <h2 class="text-3xl font-bold text-slate-800">Create Course</h2>
      <p class="text-slate-500 mt-1">Add a new course to the system</p>
    </div>

    <!-- Card -->
    <form
      @submit.prevent="submit"
      class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 space-y-6"
    >
      <!-- Section: Course Info -->
      <div>
        <h3 class="text-lg font-semibold text-slate-700 mb-3">Course Information</h3>

        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-medium text-slate-600">Course Title</label>
            <input
              v-model="form.title"
              placeholder="Introduction to Programming"
              class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
            />
          </div>

          <div>
            <label class="text-sm font-medium text-slate-600">Course Code</label>
            <input
              v-model="form.code"
              placeholder="CS101"
              class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
            />
          </div>
        </div>

        <div class="mt-4">
          <label class="text-sm font-medium text-slate-600">Description</label>
          <textarea
            v-model="form.description"
            rows="3"
            placeholder="Brief description of the course"
            class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          ></textarea>
        </div>
      </div>

      <!-- Section: Instructor -->
      <div>
        <h3 class="text-lg font-semibold text-slate-700 mb-3">Assign Instructor</h3>

        <div>
          <label class="text-sm font-medium text-slate-600">Instructor</label>
          <select
            v-model="form.instructor_id"
            class="mt-1 w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
          >
            <option value="">Select Instructor</option>
            <option v-for="i in instructors" :key="i.id" :value="i.id">
              {{ i.user?.name }}
            </option>
          </select>
        </div>
      </div>

      <!-- Error -->
      <div v-if="error" class="bg-rose-50 text-rose-700 p-3 rounded-xl text-sm">
        {{ error }}
      </div>

      <!-- Actions -->
      <div class="flex justify-between items-center pt-4 border-t">
        <router-link
          to="/courses"
          class="px-4 py-2 rounded-xl border border-slate-200 hover:bg-slate-50 font-medium"
        >
          Cancel
        </router-link>

        <button
          class="px-6 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow-sm disabled:opacity-50"
          :disabled="submitting"
        >
          {{ submitting ? "Creating..." : "Create Course" }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted } from "vue";
import { api, handleApiError } from "../../api/client";
import { useRouter } from "vue-router";

const router = useRouter();

const submitting = ref(false);
const error = ref("");
const instructors = ref<any[]>([]);

const form = reactive({
  title: "",
  code: "",
  description: "",
  instructor_id: "",
});

// Fetch instructors
async function fetchInstructors() {
  try {
    const res = await api.get("/instructors");
    instructors.value = Array.isArray(res.data)
      ? res.data
      : res.data.data ?? [];
  } catch (err) {
    error.value = handleApiError(err);
  }
}

// Submit
async function submit() {
  submitting.value = true;
  error.value = "";

  try {
    await api.post("/courses", form);
    router.push("/courses");
  } catch (err) {
    error.value = handleApiError(err);
  } finally {
    submitting.value = false;
  }
}

onMounted(fetchInstructors);
</script>
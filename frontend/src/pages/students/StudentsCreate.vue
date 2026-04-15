<template>
  <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-10">
      
      <div class="md:col-span-1 mb-8 md:mb-0">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Register Student</h2>
        <p class="mt-3 text-sm text-slate-500 leading-relaxed">
          Create a new student record. This information will automatically provision their academic dashboard and secure login credentials.
        </p>

        <div class="mt-8 p-4 bg-indigo-50 rounded-2xl border border-indigo-100/60">
          <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-xs text-indigo-800 leading-relaxed font-medium">
              Ensure the Student ID matches the official university registry format to avoid sync issues with the main database.
            </p>
          </div>
        </div>
      </div>

      <div class="md:col-span-2">
        <form @submit.prevent="submit" class="bg-white shadow-sm ring-1 ring-slate-200 rounded-2xl overflow-hidden transition-all hover:shadow-md">
          
          <div class="p-6 sm:p-8 space-y-8">
            <div>
              <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Personal Details</h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                  <label class="text-sm font-medium text-slate-700">Full Name</label>
                  <input v-model="form.name" type="text" placeholder="e.g. Jane Doe" 
                    class="w-full px-4 py-2.5 bg-slate-50/50 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors outline-none sm:text-sm" />
                </div>

                <div class="space-y-1.5">
                  <label class="text-sm font-medium text-slate-700">Email Address</label>
                  <input v-model="form.email" type="email" placeholder="jane@university.edu" 
                    class="w-full px-4 py-2.5 bg-slate-50/50 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors outline-none sm:text-sm" />
                </div>

                <div class="space-y-1.5 sm:col-span-2">
                  <label class="text-sm font-medium text-slate-700">Temporary Password</label>
                  <input v-model="form.password" type="password" placeholder="••••••••" 
                    class="w-full px-4 py-2.5 bg-slate-50/50 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors outline-none sm:text-sm" />
                </div>
              </div>
            </div>

            <hr class="border-slate-100" />

            <div>
              <h3 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-4">Academic Profile</h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-1.5 sm:col-span-2">
                  <label class="text-sm font-medium text-slate-700">Student ID</label>
                  <input v-model="form.student_id" type="text" placeholder="e.g. STU-2024-899" 
                    class="w-full px-4 py-2.5 bg-slate-50/50 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors outline-none sm:text-sm font-mono text-slate-600" />
                </div>

                <div class="space-y-1.5">
                  <label class="text-sm font-medium text-slate-700">Major</label>
                  <input v-model="form.major" type="text" placeholder="e.g. Software Engineering" 
                    class="w-full px-4 py-2.5 bg-slate-50/50 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors outline-none sm:text-sm" />
                </div>

                <div class="space-y-1.5">
                  <label class="text-sm font-medium text-slate-700">Batch</label>
                  <input v-model="form.batch" type="text" placeholder="e.g. Class of 2028" 
                    class="w-full px-4 py-2.5 bg-slate-50/50 rounded-xl border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-colors outline-none sm:text-sm" />
                </div>
              </div>
            </div>

            <div v-if="error" class="flex items-center gap-2 p-3 text-sm text-red-600 bg-red-50 rounded-lg border border-red-100">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <span>{{ error }}</span>
            </div>
          </div>

          <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
            <router-link to="/students" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
              Cancel
            </router-link>

            <button 
              type="submit" 
              :disabled="submitting"
              class="relative inline-flex items-center justify-center px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow-sm hover:shadow-md transition-all active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed min-w-[140px]"
            >
              <span :class="{ 'opacity-0': submitting }">Create Student</span>
              
              <svg v-if="submitting" class="absolute w-5 h-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
            </button>
          </div>
          
        </form>
      </div>
    </div>
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
  name: "",
  email: "",
  password: "",
  student_id: "",
  major: "",
  batch: "",
});

async function submit() {
  submitting.value = true;
  error.value = "";
  try {
    await api.post("/students", form);
    router.push("/students");
  } catch (err) {
    error.value = handleApiError(err);
  } finally {
    submitting.value = false;
  }
}
</script>
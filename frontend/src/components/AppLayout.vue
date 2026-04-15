<template>
  <div class="min-h-screen bg-slate-50">
    <div class="flex">
      <Sidebar />

      <div class="flex-1 flex flex-col">
        <header class="sticky top-0 z-10 bg-white/90 backdrop-blur border-b border-slate-200">
          <div class="flex items-center justify-between px-4 sm:px-8 py-4">
            <div>
              <h1 class="text-lg sm:text-xl font-bold text-slate-900">Dashboard</h1>
              <p class="text-xs sm:text-sm text-slate-600">
                Manage Students, Instructors, Courses and Enrollments
              </p>
            </div>

            <div class="flex items-center gap-3">
              <span class="hidden sm:inline-flex px-3 py-2 rounded-xl bg-indigo-500/10 text-indigo-700 border border-indigo-500/20 text-sm">
                API Connected
              </span>
            </div>
          </div>
        </header>

        <main class="p-4 sm:p-8">
          <router-view />
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import Sidebar from "./Sidebar.vue";
</script>
<template>
  <aside class="hidden lg:flex lg:flex-col w-72 bg-slate-900 text-slate-100 border-r border-slate-800">
    <div class="p-6">
      <div class="flex items-center gap-3">
        <div class="h-10 w-10 rounded-xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center">
          <span class="text-indigo-200 font-bold">S</span>
        </div>
        <div>
          <p class="font-semibold leading-tight">Student Portal</p>
          <p class="text-xs text-slate-400">Admin / Registration</p>
        </div>
      </div>
    </div>

    <nav class="px-4 pb-6 space-y-2">
      <router-link
        to="/students"
        class="block rounded-xl px-3 py-2 transition"
        :class="isActive('/students')"
      >
        Students
      </router-link>

      <router-link
        to="/instructors"
        class="block rounded-xl px-3 py-2 transition"
        :class="isActive('/instructors')"
      >
        Instructors
      </router-link>

      <router-link
        to="/courses"
        class="block rounded-xl px-3 py-2 transition"
        :class="isActive('/courses')"
      >
        Courses
      </router-link>

      <router-link
        to="/enrollments"
        class="block rounded-xl px-3 py-2 transition"
        :class="isActive('/enrollments')"
      >
        Enrollments
      </router-link>
    </nav>

    <div class="mt-auto p-4 border-t border-slate-800">
      <div class="rounded-xl bg-slate-800/60 p-4">
        <p class="text-sm font-semibold">Quick Tips</p>
        <p class="text-xs text-slate-300 mt-1">
          Use “Create” buttons to add new records.
        </p>
      </div>
    </div>
  </aside>
</template>

<script setup>
import { useRoute } from "vue-router";

const route = useRoute();

function isActive(prefix) {
  return route.path.startsWith(prefix)
    ? "bg-indigo-500/20 border border-indigo-500/30 text-indigo-100"
    : "hover:bg-slate-800/60 border border-transparent";
}
</script>
<template>
  <div class="max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
      <div>
        <h2 class="text-2xl font-bold text-slate-900">Instructors</h2>
        <p class="text-slate-600 text-sm">Manage instructor profiles</p>
      </div>

      <router-link
        to="/instructors/create"
        class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold"
      >
        + Create Instructor
      </router-link>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="p-4 border-b border-slate-200">
        <input
          v-model="search"
          type="text"
          placeholder="Search by instructor_id or name..."
          class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-400"
        />
      </div>

      <div class="overflow-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-slate-50 text-slate-600">
            <tr>
              <th class="text-left px-4 py-3 font-semibold">ID</th>
              <th class="text-left px-4 py-3 font-semibold">Full Name</th>
              <th class="text-left px-4 py-3 font-semibold">Instructor No.</th>
              <th class="text-left px-4 py-3 font-semibold">Department</th>
              <th class="text-right px-4 py-3 font-semibold">Actions</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="i in filtered" :key="i.id" class="border-t border-slate-100">
              <td class="px-4 py-3 text-slate-700">{{ i.id }}</td>
              <td class="px-4 py-3 text-slate-700">{{ i.full_name }}</td>
              <td class="px-4 py-3 text-slate-700">{{ i.instructor_id }}</td>
              <td class="px-4 py-3 text-slate-700">{{ i.department || '-' }}</td>

              <td class="px-4 py-3">
                <div class="flex justify-end gap-2">
                  <router-link
                    :to="`/instructors/${i.id}/edit`"
                    class="px-3 py-1.5 rounded-xl border border-indigo-200 text-indigo-700 hover:bg-indigo-50 font-semibold"
                  >
                    Edit
                  </router-link>

                  <button
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold"
                    @click="removeInstructor(i.id)"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="!loading && filtered.length === 0">
              <td colspan="5" class="px-4 py-6 text-center text-slate-500">
                No instructors found.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="loading" class="p-4 text-slate-600 text-sm">Loading...</div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { api, handleApiError } from "../../api/client";
import { useRouter } from "vue-router";

const router = useRouter();
const loading = ref(false);
const instructors = ref([]);
const search = ref("");

const filtered = computed(() => {
  const q = search.value.trim().toLowerCase();
  if (!q) return instructors.value;
  return instructors.value.filter((i) => {
    return (
      String(i.instructor_id || "").toLowerCase().includes(q) ||
      String(i.full_name || "").toLowerCase().includes(q)
    );
  });
});

async function fetchInstructors() {
  loading.value = true;
  try {
    const res = await api.get("/instructors");
    instructors.value = Array.isArray(res.data) ? res.data : res.data.data ?? [];
  } catch (err) {
    alert(handleApiError(err));
  } finally {
    loading.value = false;
  }
}

async function removeInstructor(id) {
  if (!confirm("Delete this instructor?")) return;

  try {
    await api.delete(`/instructors/${id}`);
    await fetchInstructors();
  } catch (err) {
    alert(handleApiError(err));
  }
}

onMounted(fetchInstructors);
</script>
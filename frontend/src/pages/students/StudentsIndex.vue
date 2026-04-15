<template>
  <div class="max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
      <div>
        <h2 class="text-2xl font-bold text-slate-900">Students</h2>
        <p class="text-slate-600 text-sm">Manage student accounts & profiles</p>
      </div>

      <router-link
        to="/students/create"
        class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold"
      >
        + Create Student
      </router-link>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="p-4 border-b border-slate-200">
        <input
          v-model="search"
          type="text"
          placeholder="Search by student_id or name..."
          class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-400"
        />
      </div>

      <div class="overflow-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-slate-50 text-slate-600">
            <tr>
              <th class="text-left px-4 py-3 font-semibold">ID</th>
              <th class="text-left px-4 py-3 font-semibold">Name</th>
              <th class="text-left px-4 py-3 font-semibold">Email</th>
              <th class="text-left px-4 py-3 font-semibold">Student No.</th>
              <th class="text-left px-4 py-3 font-semibold">Major</th>
              <th class="text-left px-4 py-3 font-semibold">Batch</th>
              <th class="text-right px-4 py-3 font-semibold">Actions</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="s in filtered" :key="s.id" class="border-t border-slate-100">
              <td class="px-4 py-3 text-slate-700">{{ s.id }}</td>
              <td class="px-4 py-3 text-slate-700">{{ s.user?.name }}</td>
              <td class="px-4 py-3 text-slate-700">{{ s.user?.email }}</td>
              <td class="px-4 py-3 text-slate-700">{{ s.student_id }}</td>
              <td class="px-4 py-3 text-slate-700">{{ s.major || '-' }}</td>
              <td class="px-4 py-3 text-slate-700">{{ s.batch || '-' }}</td>

              <td class="px-4 py-3">
                <div class="flex justify-end gap-2">
                  <router-link
                    :to="`/students/${s.id}/edit`"
                    class="px-3 py-1.5 rounded-xl border border-indigo-200 text-indigo-700 hover:bg-indigo-50 font-semibold"
                  >
                    Edit
                  </router-link>

                  <button
                    class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold"
                    @click="removeStudent(s.id)"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="!loading && filtered.length === 0">
              <td colspan="7" class="px-4 py-6 text-center text-slate-500">
                No students found.
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
const students = ref([]);
const search = ref("");

const filtered = computed(() => {
  const q = search.value.trim().toLowerCase();
  if (!q) return students.value;
  return students.value.filter((s) => {
    return (
      String(s.student_id).toLowerCase().includes(q) ||
      String(s.user?.name || "").toLowerCase().includes(q)
    );
  });
});

async function fetchStudents() {
  loading.value = true;
  try {
    const res = await api.get("/students"); // expects pagination or array depending on your controller
    // If paginated response: res.data.data
    students.value = Array.isArray(res.data) ? res.data : res.data.data ?? [];
  } catch (err) {
    alert(handleApiError(err));
  } finally {
    loading.value = false;
  }
}

async function removeStudent(id) {
  if (!confirm("Delete this student?")) return;

  try {
    await api.delete(`/students/${id}`);
    await fetchStudents();
  } catch (err) {
    alert(handleApiError(err));
  }
}

onMounted(fetchStudents);
</script>
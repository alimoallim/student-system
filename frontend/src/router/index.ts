import { createRouter, createWebHistory } from "vue-router";
import CoursesIndex from "../pages/courses/CoursesIndex.vue";
import CoursesCreate from "../pages/courses/CoursesCreate.vue";
import CoursesEdit from "../pages/courses/CoursesEdit.vue";

import EnrollmentsIndex from "../pages/enrollments/EnrollmentsIndex.vue";
import EnrollmentsCreate from "../pages/enrollments/EnrollmentsCreate.vue";

import StudentsIndex from "../pages/students/StudentsIndex.vue";
import StudentsCreate from "../pages/students/StudentsCreate.vue";
import StudentsEdit from "../pages/students/StudentsEdit.vue";

import InstructorsIndex from "../pages/instructors/InstructorsIndex.vue";
import InstructorsCreate from "../pages/instructors/InstructorsCreate.vue";
import InstructorsEdit from "../pages/instructors/InstructorsEdit.vue";




export default createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", redirect: "/students" },
    

    { path: "/students", component: StudentsIndex },
    { path: "/students/create", component: StudentsCreate },
    { path: "/students/:id/edit", component: StudentsEdit },

    { path: "/instructors", component: InstructorsIndex },
    { path: "/instructors/create", component: InstructorsCreate },
    { path: "/instructors/:id/edit", component: InstructorsEdit },
    

    { path: "/courses", component: CoursesIndex },
    { path: "/courses/create", component: CoursesCreate },
    { path: "/courses/:id/edit", component: CoursesEdit },

    { path: "/enrollments", component: EnrollmentsIndex },
    { path: "/enrollments/create", component: EnrollmentsCreate },
  ],
});
import {asistenciasAlumno, asistenciasProfesor} from "../portalAlumno/asistencia.js";


AOS.init();

function revealAsistencias(){
    asistenciasAlumno.style.display = "none";
    asistenciasProfesor.style.display = "flex";
}
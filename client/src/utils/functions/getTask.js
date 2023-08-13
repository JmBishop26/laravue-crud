import axios from "axios";

const url = 'http://127.0.0.1:8000/api'
export async function getAllTasks() {
    try {
      const response = await axios.get(url+"/tasks");
      return response
    } catch (error) {
      return error
    }
}

export async function getTask(){

}

export async function newTask(formData){
  try {
    const response = await axios.post(url+'/create', formData)
    return response.data
  } catch (error) {
    return error
  }
}

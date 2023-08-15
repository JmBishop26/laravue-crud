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

export async function getTask(id){
  try {
    const response = await axios.get(url+"/tasks/"+id)
    return response
  } catch (error) {
    return error
  }
}

export async function newTask(formData){
  try {
    const response = await axios.post(url+'/create', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    return response.data
  } catch (error) {
    return error
  }
}

export async function deleteTask(id){
  try {
    const response = await axios.delete(url+'/delete/'+id)
    return response.data
  } catch (error) {
    return error
  }
}

export async function editTask(formData, id){
  try {
    const response = await axios.post(url+'/tasks/edit/'+id, formData,{
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    return response.data
  } catch (error) {
    return error
  }
}


export async function getFileObject(file){
  try {
    const response = await axios.get(url+'/tasks/uploads/'+file, {responseType: 'arraybuffer'})
    return response
  } catch (error) {
    return error
  }
}


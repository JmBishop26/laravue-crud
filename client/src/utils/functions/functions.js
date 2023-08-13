export function getInputValues(instance) {
  return {
    title: instance.title,
    description: instance.description,
    status: instance.status===true?'complete':'ongoing',
    file: instance.file.name,
  };
}

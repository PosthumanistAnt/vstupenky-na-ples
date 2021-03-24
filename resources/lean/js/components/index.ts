import { registerComponents } from '@leanadmin/alpine-typescript';

// Loop through all files in this directory
const files = require.context('./', true, /.*.ts/)
    .keys()
    .map(file => file.substr(2, file.length - 5)) // Remove ./ and .ts
    .filter(file => file !== 'index')
    .reduce((files: { [name: string]: Function }, file: string) => {
        files[file] = require(`./${file}.ts`).default;

        return files;
}, {});

// Register the files as Alpine components
registerComponents(files);

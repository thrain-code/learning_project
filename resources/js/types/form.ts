import { Component } from "vue";

export interface FormField<T extends string = string> {
  label: string;          // Tambahkan
  type: InputType;        // Tambahkan
  model: T;               // Sudah ada
  required?: boolean;     // Tambahkan
  icon: Component;        // Tambahkan
  autocomplete?: string;  // Tambahkan
  placeholder?: string;   // Sudah ada
  error?: string;         // Sudah ada
}

// resources/js/types/form.ts
export type InputType = 
  | 'text'
  | 'password'
  | 'email'
  | 'number'
  | 'tel'
  | 'date'
  | 'url'
  | 'search'
  | 'color'
  | 'range'
  | 'hidden'
  | 'file'
  | 'textarea';

export interface InputFieldProps<T = any> {
  label: string;
  type?: InputType;
  modelValue: T;
  required?: boolean;
  icon: Component;
  autocomplete?: string;
  error?: boolean;
  placeholder?: string;
}
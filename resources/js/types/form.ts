// resources/js/types/form.ts
import type { Component } from "vue";

export type InputType = 
  | 'text'
  | 'password'
  | 'email'
  | 'number'
  | 'tel'
  | 'date'
  | 'url'
  | 'search'
  | 'textarea';

export interface FormField<T extends string = string> {
  label: string;
  type: InputType;
  model: T;
  required?: boolean;
  icon: Component;
  autocomplete?: string;
  placeholder?: string;
  error?: string;
}

export interface InputFieldProps<T = string> {
  label: string;
  type?: InputType;
  modelValue: T;
  required?: boolean;
  icon: Component;
  autocomplete?: string;
  error?: boolean;
  placeholder?: string;
}
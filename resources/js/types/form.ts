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
  | 'color'
  | 'range'
  | 'hidden'
  | 'file'
  | 'textarea';

export interface InputFieldProps<T = any> {
  label: string;
  modelValue: T;
  type?: InputType;
  
  required?: boolean;
  icon?: Component;
  autocomplete?: string;
  placeholder?: string;
  error?: boolean;
  accept?: string;
}

export interface FormField<T extends string = string> extends InputFieldProps {
  model: T;
  errorKey: string;
  type: InputType;
}

export interface SelectOption {
  value: string | number;
  label: string;
}

export interface SelectProps {
  options: SelectOption[];
  label: string;
  modelValue: string | number | null;
  placeholder?: string;
  required?: boolean;
  error?: boolean;
  icon?: Component;
}
<script setup>
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import { Checkbox } from "@/Components/ui/checkbox";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";
import {
    Form,
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/Components/ui/veeForm";
import { toast } from "@/Components/ui/toast";
import { toTypedSchema } from "@vee-validate/zod";

import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps(["name", "email", "password", "password_confirmation", "errors"]);
const emit = defineEmits(["submit"]);
const name = defineModel("name");
const email = defineModel("email");
const password = defineModel("password");
const password_confirmation = defineModel("password_confirmation");
const terms = defineModel("terms");
import { useForm } from "vee-validate";

import * as z from "zod";

const veeFormFormSchema = toTypedSchema(
    z.object({
        name: z.string().min(2).max(50),
        email: z.string(),
        password: z.string(),
        password_confirmation: z.string(),
        terms: z.any(),
    })
);

const veeForm = useForm({
    validationSchema: veeFormFormSchema,
});
const handleChange = (v) => {
    terms.value = v;
    veeForm.setFieldValue("terms", v);
    console.log(" handleChange ", {
        terms: terms.value,
        formValue: veeForm.values.terms,
        v,
    });
};

const handleRegister = veeForm.handleSubmit(() => {
    console.log({ veeForm });

    emit("submit", { name, email, password, password_confirmation, terms });
});
</script>

const HOST = import.meta.env.VITE_STORAGE_HOST || "http://localhost:9000";
const BUCKET = import.meta.env.VITE_STORAGE_BUCKET || "glitchmart";

export const getProductPrimaryImageUrl = (product) => {
    if (product?.primary_image?.image_path) {
        // Remove any leading slashes and combine with bucket path
        const imagePath = product.primary_image.image_path.replace(/^\/+/, "");
        return `${HOST}/${BUCKET}/${imagePath}`;
    }
    return "https://placehold.co/600x600?text=No+Image";
};

export const getImageUrl = (imagePath) => {
    if (imagePath) {
        const cleanPath = imagePath.replace(/^\/+/, "");
        return `${HOST}/${BUCKET}/${cleanPath}`;
    }
    return null;
};

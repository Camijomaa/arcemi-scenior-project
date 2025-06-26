import os
import faiss
import pickle
import numpy as np
from PIL import Image
from torchvision import models, transforms
import torch

IMAGE_FOLDER = "product_images"
INDEX_FILE = "product_index.faiss"
DATA_FILE = "product_data.pkl"

model = models.resnet50(pretrained=True)
model.fc = torch.nn.Identity()
model.eval()

transform = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor(),
])

filenames = []
features = []

for file in os.listdir(IMAGE_FOLDER):
    if file.endswith(".jpg") or file.endswith(".png"):
        img = Image.open(os.path.join(IMAGE_FOLDER, file)).convert("RGB")
        tensor = transform(img).unsqueeze(0)
        with torch.no_grad():
            vec = model(tensor).numpy().flatten()
        filenames.append(file)
        features.append(vec)

features = np.array(features).astype('float32')
index = faiss.IndexFlatL2(features.shape[1])
index.add(features)

faiss.write_index(index, INDEX_FILE)
with open(DATA_FILE, 'wb') as f:
    pickle.dump(filenames, f)

from flask import Flask, request, jsonify
from flask_cors import CORS
import faiss
import pickle
import numpy as np
from PIL import Image
from torchvision import models, transforms
import torch
import io

app = Flask(__name__)
CORS(app)

model = models.resnet50(pretrained=True)
model.fc = torch.nn.Identity()
model.eval()

transform = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor(),
])

index = faiss.read_index("product_index.faiss")
with open("product_data.pkl", 'rb') as f:
    image_files = pickle.load(f)

@app.route('/visual-search', methods=['POST'])
def visual_search():
    file = request.files['image']
    img = Image.open(io.BytesIO(file.read())).convert("RGB")
    tensor = transform(img).unsqueeze(0)
    with torch.no_grad():
        vec = model(tensor).numpy().astype('float32')

    D, I = index.search(vec, k=5)
    results = [image_files[i] for i in I[0]]
    return jsonify(results)

if __name__ == '__main__':
    app.run(port=5000, debug=True)

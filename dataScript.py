import pandas as pd
from pathlib import Path

inPutDir = Path("RedditDataFixed")
outPutDir = Path("RedditData75")

for file in inPutDir.glob("*.csv"):
    print(f"Processing: {file.name}")

    data = pd.read_csv(file)
    df = data.sample(frac=0.75, random_state=30)

    output_file_path = outPutDir / file.name
    df.to_csv(output_file_path, index = False)

    print(f"Saved to: {output_file_path}")

print("Processing complete!")
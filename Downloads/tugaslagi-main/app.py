from flask import Flask, render_template, request
from model import clustering
import os
import matplotlib.pyplot as plt

app = Flask(__name__)

def create_plots(df, inertia, sil, summary):
    col = df.select_dtypes(include=['number']).columns[0]

    # Cluster
    plt.figure(figsize=(4,3))
    plt.scatter(range(len(df)), df[col], c=df['cluster'])
    plt.title("Visualisasi Cluster")
    plt.grid()
    plt.savefig("static/cluster.png")
    plt.close()

    # Elbow
    plt.figure(figsize=(4,3))
    plt.plot(range(1, len(inertia)+1), inertia, marker='o')
    plt.title("Elbow Method")
    plt.grid()
    plt.savefig("static/elbow.png")
    plt.close()

    # Silhouette
    plt.figure(figsize=(4,3))
    plt.bar(['Score'], [sil])
    plt.title("Silhouette Score")
    plt.savefig("static/silhouette.png")
    plt.close()

    # Summary
    plt.figure(figsize=(4,3))
    summary.plot(kind='bar')
    plt.title("Ringkasan Cluster")
    plt.savefig("static/summary.png")
    plt.close()


@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        file = request.files.get('file')

        if not file or file.filename == '':
            return render_template('index.html', error="File belum dipilih!")

        if not file.filename.endswith('.csv'):
            return render_template('index.html', error="File harus CSV!")

        path = "data.csv"
        file.save(path)

        if os.stat(path).st_size == 0:
            return render_template('index.html', error="File kosong!")

        df, error, inertia, sil, summary = clustering(path)

        if error:
            return render_template('index.html', error=error)

        create_plots(df, inertia, sil, summary)

        total = len(df)
        rata = round(df.select_dtypes(include=['number']).iloc[:,0].mean(), 2)

        return render_template(
            'result.html',
            tables=[df.to_html(classes='table table-bordered text-center')],
            total=total,
            rata=rata,
            summary=summary.to_html(classes='table table-striped text-center')
        )

    return render_template('index.html')


if __name__ == '__main__':
    app.run(debug=True)

    import os

port = int(os.environ.get("PORT", 5000))
app.run(host="0.0.0.0", port=port)

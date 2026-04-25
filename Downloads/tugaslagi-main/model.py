import pandas as pd
from sklearn.cluster import KMeans
from sklearn.metrics import silhouette_score

def clustering(file_path):
    df = pd.read_csv(file_path)

    if df.empty:
        return None, "Dataset kosong!", None, None, None

    df.columns = df.columns.str.lower().str.replace(" ", "_")

    for col in df.columns:
        df[col] = pd.to_numeric(
            df[col].astype(str).str.replace(',', '.'),
            errors='coerce'
        )

    df_numeric = df.select_dtypes(include=['number'])
    df_numeric = df_numeric.dropna(axis=1, how='all')

    if df_numeric.shape[1] == 0:
        return None, "Tidak ada kolom numerik!", None, None, None

    df_numeric = df_numeric.fillna(df_numeric.mean()).fillna(0)

    # ELBOW
    inertia = []
    for k in range(1, 6):
        km = KMeans(n_clusters=k, random_state=42)
        km.fit(df_numeric)
        inertia.append(km.inertia_)

    # CLUSTER
    kmeans = KMeans(n_clusters=3, random_state=42)
    df_numeric['cluster'] = kmeans.fit_predict(df_numeric)

    # SILHOUETTE
    try:
        sil = silhouette_score(df_numeric.drop(columns=['cluster']), df_numeric['cluster'])
        sil = round(sil, 3)
    except:
        sil = 0

    summary = df_numeric.groupby('cluster').mean().round(2)

    df['cluster'] = df_numeric['cluster']

    return df, None, inertia, sil, summary
